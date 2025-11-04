<?php

namespace App\Core;

use mysqli;
use App\Connect\MySQLConnection;
use App\Util\HKT;

abstract class Model
{
    protected mysqli $connection;
    protected string $table;
    protected array $fillable = [];

    // Dùng để lưu điều kiện where tạm thời
    protected array $wheres = [];

    public function __construct()
    {
        // Lấy kết nối duy nhất từ MySQLConnection
        $this->connection = MySQLConnection::getInstance()->connect();
    }

    /**
     * Thêm bản ghi mới (create)
     */
    public function create(array $data)
    {
        $fields = array_intersect_key($data, array_flip($this->fillable));

        if (empty($fields)) {
            throw new \InvalidArgumentException("Không có dữ liệu hợp lệ để insert.");
        }

        $columns = implode(',', array_keys($fields));
        $placeholders = implode(',', array_fill(0, count($fields), '?'));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);

        $types = str_repeat('s', count($fields)); // tất cả string
        $values = array_values($fields);

        $stmt->bind_param($types, ...$values);

        if (!$stmt->execute()) {
            throw new \RuntimeException("Lỗi khi insert: " . $stmt->error);
        }

        return $this->connection->insert_id;
    }

    /**
     * Cập nhật bản ghi theo id
     */
    public function update(int $id, array $data)
    {
        $fields = array_intersect_key($data, array_flip($this->fillable));

        if (empty($fields)) {
            // neu nhu truong data muon update khong nam trong array fillable o model
            throw new \InvalidArgumentException("Không có dữ liệu hợp lệ để update.");
        }

        $setPart = implode(',', array_map(fn($key) => "$key = ?", array_keys($fields)));
        $sql = "UPDATE {$this->table} SET {$setPart} WHERE id = ?";



        $stmt = $this->connection->prepare($sql);

        $types = str_repeat('s', count($fields)) . 'i';
        $values = array_values($fields);
        $values[] = $id;
        // HKT::dd($types);

        $stmt->bind_param($types, ...$values);

        if (!$stmt->execute()) {
            throw new \RuntimeException("Lỗi khi update: " . $stmt->error);
        }

        return true;
    }

    /**
     * Xóa bản ghi (delete)
     */
    public function delete(int $id)
    {
        // $sql = "DELETE FROM {$this->table} WHERE id = ?";
        // $stmt = $this->connection->prepare($sql);
        // $stmt->bind_param('i', $id);

        $sql = "update {$this->table} set status = 0 where id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('i', $id);

        if (!$stmt->execute()) {
            throw new \RuntimeException("Lỗi khi delete: " . $stmt->error);
        }

        return true;
    }

    /**
     * Lấy tất cả bản ghi
     */
    public function all($where = '')
    {
        $w = $where != '' ? "where {$where}" : "";
        $result = $this->connection->query("SELECT * FROM {$this->table} {$w}");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Tìm bản ghi theo id
     */
    public function find(int $id): ?array
    {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE id = ? and status = 1 limit 0, 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    /**
     * Thêm điều kiện WHERE (chainable như Eloquent)
     */
    public function where(string $column, string $operator, $value): static
    {
        $this->wheres[] = [$column, $operator, $value];
        return $this;
    }

    /**
     * Lấy danh sách bản ghi có điều kiện
     */
    public function get(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        $types = '';

        if (!empty($this->wheres)) {
            $whereSql = [];
            foreach ($this->wheres as $where) {
                [$column, $operator, $value] = $where;
                $whereSql[] = "$column $operator ?";
                $params[] = $value;
                $types .= 's';
            }
            $sql .= " WHERE " . implode(' AND ', $whereSql);
        }

        $stmt = $this->connection->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // reset điều kiện sau khi query
        $this->wheres = [];

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Lấy bản ghi đầu tiên theo điều kiện WHERE
     */
    public function first(): ?array
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        $types = '';

        if (!empty($this->wheres)) {
            $whereSql = [];
            foreach ($this->wheres as $where) {
                [$column, $operator, $value] = $where;
                $whereSql[] = "$column $operator ?";
                $params[] = $value;
                $types .= 's';
            }
            $sql .= " WHERE " . implode(' AND ', $whereSql);
        }

        $sql .= " LIMIT 1";

        $stmt = $this->connection->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // reset điều kiện để không ảnh hưởng query sau
        $this->wheres = [];

        return $result->fetch_assoc() ?: null;
    }
}
