<?php

namespace App\Models;

use App\OOP\Models\Employee;
use App\Services\SupabaseClient;
use App\Exceptions\InvalidEmployeeDataException;

class EmployeeModel
{
    private SupabaseClient $supabase;
    private string $table = 'employees';

    public function __construct()
    {
        $this->supabase = new SupabaseClient();
    }

    public function create(Employee $employee): array
    {
        $data = [
            'name' => $employee->getName(),
            'age' => $employee->getAge(),
            'email' => $employee->getEmail(),
            'position' => $employee->getPosition(),
            'salary' => $employee->getSalary(),
            'created_at' => now()->toISOString()
        ];

        $result = $this->supabase->insert($this->table, $data);
        
        if (empty($result)) {
            throw new InvalidEmployeeDataException('No se pudo crear el empleado');
        }

        return $result[0];
    }

    public function findAll(): array
    {
        return $this->supabase->select($this->table);
    }

    public function findById(int $id): ?array
    {
        $result = $this->supabase->select($this->table, ['*'], ['id' => $id]);
        return !empty($result) ? $result[0] : null;
    }

    public function findByEmail(string $email): ?array
    {
        $result = $this->supabase->select($this->table, ['*'], ['email' => $email]);
        return !empty($result) ? $result[0] : null;
    }

    public function update(int $id, Employee $employee): array
    {
        $data = [
            'name' => $employee->getName(),
            'age' => $employee->getAge(),
            'email' => $employee->getEmail(),
            'position' => $employee->getPosition(),
            'salary' => $employee->getSalary(),
            'updated_at' => now()->toISOString()
        ];

        $result = $this->supabase->update($this->table, $data, ['id' => $id]);
        
        if (empty($result)) {
            throw new InvalidEmployeeDataException('No se pudo actualizar el empleado');
        }

        return $result[0];
    }

    public function delete(int $id): bool
    {
        return $this->supabase->delete($this->table, ['id' => $id]);
    }

    public function getStatistics(): array
    {
        $employees = $this->findAll();
        
        if (empty($employees)) {
            return [
                'total_employees' => 0,
                'average_salary' => 0,
                'average_age' => 0,
                'positions' => []
            ];
        }

        $totalSalary = array_sum(array_column($employees, 'salary'));
        $totalAge = array_sum(array_column($employees, 'age'));
        $positions = array_count_values(array_column($employees, 'position'));

        return [
            'total_employees' => count($employees),
            'average_salary' => round($totalSalary / count($employees), 2),
            'average_age' => round($totalAge / count($employees), 1),
            'positions' => $positions
        ];
    }
}
