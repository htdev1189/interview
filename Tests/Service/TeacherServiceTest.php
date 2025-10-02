<?php

use PHPUnit\Framework\TestCase;
use App\Repository\TeacherRepository;
use App\Service\TeacherService;
use App\Connect\MySQLConnection;
use App\Model\Student;
use App\Model\Teacher;


class TeacherServiceTest extends TestCase
{

    // test with connect
    private $connection;

    // 
    private $teacherRepositoryMock;
    private $teacherService;

    protected function setUp(): void
    {
        $this->connection = MySQLConnection::getInstance()->connect();

        // Tạo mock cho StudentRepository
        $this->teacherRepositoryMock = $this->createMock(TeacherRepository::class);

        // Inject vào StudentService
        $this->teacherService = new TeacherService($this->teacherRepositoryMock);
    }
    // public function testGetAllTeachers()
    // {

    //     $repository = new TeacherRepository($this->connection);
    //     $service = new TeacherService($repository);
    //     $teachers = $service->getAllTeachers();

    //     // ✅ Kiểm tra có 3 object
    //     $this->assertCount(3, $teachers);

    //     // ✅ Kiểm tra kiểu dữ liệu
    //     $this->assertInstanceOf(Teacher::class, $teachers[0]);

    //     // ✅ Kiểm tra dữ liệu thực tế (ví dụ teacher đầu tiên)
    //     $this->assertEquals("Hoang Van Ha", $teachers[0]->name);
    //     $this->assertEquals("hvh@hcmus.edu.vn", $teachers[0]->email);
    // }

    // public function it_can_get_all_students()
    // {
    //     $fakeTeachers = [
    //         ['id' => 1, 'name' => 'Nguyen Van A'],
    //         ['id' => 2, 'name' => 'Tran Thi B'],
    //     ];

    //     $fakeTeachers = 1;
    //     $this->teacherRepositoryMock
    //         ->method('findAll')
    //         ->willReturn($fakeTeachers);

    //     $result = $this->teacherService->getAllTeachers();

    //     // Sẽ FAIL vì name thực tế là "Nguyen Van A"
    //     $this->assertEquals('1', $result);
    // }


    // public function testGetActiveTeachers()
    // {
    //     $fakeTeachers = [
    //         ['id' => 1, 'name' => 'Nguyen Van A', 'status' => 1],
    //         ['id' => 2, 'name' => 'Tran Thi B', 'status' => 0], // inactive
    //     ];

    //     $this->teacherRepositoryMock
    //         ->method('getAll')
    //         ->willReturn($fakeTeachers);

    //     $service = new TeacherService($this->teacherRepositoryMock);
    //     $result = $service->getAllTeachers();

    //     // ✅ Mong đợi chỉ còn 1 teacher active
    //     $this->assertCount(1, $result);
    //     $this->assertEquals('Nguyen Van A', array_values($result)[0]['name']);
    // }

    // public function test(){
    //     $fakeTeachers = [
    //         new Teacher(1,"teacher1","teacher1@gmail.com",0,null),
    //         new Teacher(2,"teacher2","teacher2@gmail.com",1,null)
    //     ];

    //     $this->teacherRepositoryMock
    //         ->method('getAll')
    //         ->willReturn($fakeTeachers);

    //     $result = $this->teacherService->getAllTeachers();

    //     // ✅ Có đúng 2 teacher
    //     $this->assertCount(2, $result);

    //     // ✅ Đúng kiểu object Teacher
    //     $this->assertInstanceOf(Teacher::class, $result[0]);

    //     // ✅ Đúng dữ liệu mong muốn
    //     $this->assertEquals("teacher1", $result[0]->name);
    //     $this->assertEquals("teacher1@gmail.com", $result[0]->email);
    // }

    public function testGetActiveUser_ReturnsUser_WhenActive()
    {
        $fakeTeacher = new Teacher(1, 'teacher1', 'teacher2@gmail.com','123456', 1);

        $this->teacherRepositoryMock
            ->method('getById')
            ->willReturn($fakeTeacher);

        $result = $this->teacherService->findByID(1);

        // ✅ mong đợi có user vì status = 1
        // $this->assertNotNull($result);
        $this->assertEquals(1, $result->status); // false
    }
}
