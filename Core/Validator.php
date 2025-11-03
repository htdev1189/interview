<?php

namespace App\Core;

use mysqli;
use App\Connect\MySQLConnection;

class Validator
{
    private array $data;
    private array $rules;
    private array $errors = [];
    private mysqli $connection;

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
        // lấy connection hiện có
        $this->connection = MySQLConnection::getInstance()->connect();
        $this->run();
    }

    private function run(): void
    {
        foreach ($this->rules as $field => $ruleSet) {
            $rules = explode('|', $ruleSet);
            $value = $this->data[$field] ?? null;

            foreach ($rules as $rule) {
                $param = null;
                if (strpos($rule, ':') !== false) {
                    [$rule, $param] = explode(':', $rule, 2);
                }

                $method = 'validate' . ucfirst($rule);
                if (method_exists($this, $method)) {
                    $this->$method($field, $value, $param);
                }
            }
        }
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    private function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    // ===== Validation Rules =====

    private function validateRequired(string $field, $value): void
    {
        // Loại bỏ khoảng trắng, kiểm tra rỗng
        if (is_string($value)) {
            $value = trim($value);
        }

        if ($value === null || $value === '' || (is_array($value) && empty($value))) {
            $this->addError($field, ucfirst($field) . " is required");
        }
    }

    private function validateMin(string $field, $value, $param): void
    {
        if ($value !== null && strlen(trim((string)$value)) < (int)$param) {
            $this->addError($field, ucfirst($field) . " must be at least {$param} characters");
        }
    }

    private function validateMax(string $field, $value, $param): void
    {
        if ($value !== null && strlen(trim((string)$value)) > (int)$param) {
            $this->addError($field, ucfirst($field) . " must not exceed {$param} characters");
        }
    }

    private function validateEmail(string $field, $value): void
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, ucfirst($field) . " must be a valid email address");
        }
    }

    private function validateNumeric(string $field, $value): void
    {
        if ($value !== null && $value !== '' && !is_numeric($value)) {
            $this->addError($field, ucfirst($field) . " must be numeric");
        }
    }

    private function validateUnique(string $field, $value, $param): void
    {
        if (empty($value)) return;

        // Parse rule: unique:table,column,exceptId
        $parts = explode(',', $param);
        $table = $parts[0] ?? null;
        $column = $parts[1] ?? $field;
        $exceptId = $parts[2] ?? null;

        $sql = "SELECT COUNT(*) FROM {$table} WHERE {$column} = ?";
        $types = 's';
        $params = [$value];

        // Nếu có except ID thì thêm điều kiện WHERE id != ?
        if ($exceptId) {
            $sql .= " AND id != ?";
            $types .= 'i';
            $params[] = (int)$exceptId;
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $this->addError($field, ucfirst($field) . " already exists");
        }
    }
}
