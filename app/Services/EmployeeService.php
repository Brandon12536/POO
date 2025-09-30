<?php

namespace App\Services;

use App\OOP\Models\Employee;
use App\Models\EmployeeModel;
use App\Exceptions\InvalidEmployeeDataException;

class EmployeeService
{
    private EmployeeModel $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
    }

    public function createEmployee(array $data): array
    {
        $this->validateEmployeeData($data);
        
        $existingEmployee = $this->employeeModel->findByEmail($data['email']);
        if ($existingEmployee) {
            throw new InvalidEmployeeDataException('Ya existe un empleado con este email');
        }

        $employee = new Employee(
            $data['name'],
            $data['age'],
            $data['email'],
            $data['salary'],
            $data['position']
        );

        $result = $this->employeeModel->create($employee);
        
        return [
            'id' => $result['id'],
            'name' => $employee->getName(),
            'age' => $employee->getAge(),
            'email' => $employee->getEmail(),
            'position' => $employee->getPosition(),
            'salary' => $employee->getSalary(),
            'annual_salary' => $employee->calculateAnnualSalary(),
            'full_info' => $employee->getInfo(),
            'created_at' => $result['created_at']
        ];
    }

    public function getAllEmployees(): array
    {
        $employees = $this->employeeModel->findAll();
        
        return array_map(function($emp) {
            $employee = new Employee(
                $emp['name'],
                $emp['age'],
                $emp['email'],
                $emp['salary'],
                $emp['position']
            );
            
            return [
                'id' => $emp['id'],
                'name' => $employee->getName(),
                'age' => $employee->getAge(),
                'email' => $employee->getEmail(),
                'position' => $employee->getPosition(),
                'salary' => $employee->getSalary(),
                'annual_salary' => $employee->calculateAnnualSalary(),
                'full_info' => $employee->getInfo(),
                'created_at' => $emp['created_at'] ?? null,
                'updated_at' => $emp['updated_at'] ?? null
            ];
        }, $employees);
    }

    public function getEmployeeById(int $id): ?array
    {
        $emp = $this->employeeModel->findById($id);
        
        if (!$emp) {
            return null;
        }

        $employee = new Employee(
            $emp['name'],
            $emp['age'],
            $emp['email'],
            $emp['salary'],
            $emp['position']
        );
        
        return [
            'id' => $emp['id'],
            'name' => $employee->getName(),
            'age' => $employee->getAge(),
            'email' => $employee->getEmail(),
            'position' => $employee->getPosition(),
            'salary' => $employee->getSalary(),
            'annual_salary' => $employee->calculateAnnualSalary(),
            'full_info' => $employee->getInfo(),
            'created_at' => $emp['created_at'] ?? null,
            'updated_at' => $emp['updated_at'] ?? null
        ];
    }

    public function updateEmployee(int $id, array $data): array
    {
        $existingEmployee = $this->employeeModel->findById($id);
        if (!$existingEmployee) {
            throw new InvalidEmployeeDataException('Empleado no encontrado');
        }

        $this->validateEmployeeData($data);
        
        if ($data['email'] !== $existingEmployee['email']) {
            $emailExists = $this->employeeModel->findByEmail($data['email']);
            if ($emailExists) {
                throw new InvalidEmployeeDataException('Ya existe un empleado con este email');
            }
        }

        $employee = new Employee(
            $data['name'],
            $data['age'],
            $data['email'],
            $data['salary'],
            $data['position']
        );

        $result = $this->employeeModel->update($id, $employee);
        
        return [
            'id' => $result['id'],
            'name' => $employee->getName(),
            'age' => $employee->getAge(),
            'email' => $employee->getEmail(),
            'position' => $employee->getPosition(),
            'salary' => $employee->getSalary(),
            'annual_salary' => $employee->calculateAnnualSalary(),
            'full_info' => $employee->getInfo(),
            'updated_at' => $result['updated_at']
        ];
    }

    public function deleteEmployee(int $id): bool
    {
        $existingEmployee = $this->employeeModel->findById($id);
        if (!$existingEmployee) {
            throw new InvalidEmployeeDataException('Empleado no encontrado');
        }

        return $this->employeeModel->delete($id);
    }

    public function getStatistics(): array
    {
        return $this->employeeModel->getStatistics();
    }

    private function validateEmployeeData(array $data): void
    {
        $errors = [];

        if (empty($data['name']) || strlen($data['name']) < 2) {
            $errors[] = 'El nombre debe tener al menos 2 caracteres';
        }

        if (empty($data['age']) || $data['age'] < 18 || $data['age'] > 65) {
            $errors[] = 'La edad debe estar entre 18 y 65 años';
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El email debe ser válido';
        }

        if (empty($data['salary']) || $data['salary'] <= 0) {
            $errors[] = 'El salario debe ser mayor a 0';
        }

        if (empty($data['position']) || strlen($data['position']) < 3) {
            $errors[] = 'El puesto debe tener al menos 3 caracteres';
        }

        if (!empty($errors)) {
            throw new InvalidEmployeeDataException(implode(', ', $errors));
        }
    }
}
