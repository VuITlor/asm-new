<?php
namespace Company;

class Employee {
    private int $employeeId;
    private string $employeeName;
    private int $baseSalary;
    private int $allowance;
    private string $department;

    public function __construct(
        int $employeeId = 0,
        string $employeeName = '',
        int $baseSalary = 5000000,
        int $allowance = 0,
        string $department = ''
    ) {
        $this->employeeId = $employeeId;
        $this->employeeName = $employeeName;
        $this->baseSalary = $baseSalary;
        $this->allowance = $allowance;
        $this->department = $department;
    }

    public function getEmployeeId(): int {
        return $this->employeeId;
    }

    public function getEmployeeName(): string {
        return $this->employeeName;
    }

    public function getBaseSalary(): int {
        return $this->baseSalary;
    }

    public function getAllowance(): int {
        return $this->allowance;
    }

    public function getDepartment(): string {
        return $this->department;
    }

    public function setEmployeeId(int $employeeId): void {
        $this->employeeId = $employeeId;
    }

    public function setEmployeeName(string $employeeName): void {
        $this->employeeName = $employeeName;
    }

    public function setBaseSalary(int $baseSalary): void {
        $this->baseSalary = $baseSalary;
    }

    public function setAllowance(int $allowance): void {
        $this->allowance = $allowance;
    }

    public function setDepartment(string $department): void {
        $this->department = $department;
    }

    public function getInfo(): string {
        return "Phòng ban: {$this->employeeId}\n" ."<br>" .   
               "Tên: {$this->employeeName}\n" ."<br>" .  
               "Lương cơ bản: {$this->baseSalary}\n" ."<br>" .  
               "Phụ cấp: {$this->allowance}\n" ."<br>" .  
               "Chức Vụ: {$this->department}\n";
    }
}
?>
