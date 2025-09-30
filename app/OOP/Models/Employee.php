<?php

namespace App\OOP\Models;

use App\OOP\Abstracts\Person;

class Employee extends Person
{
    private float $salary;
    private string $position;

    public function __construct(string $name, int $age, string $email, float $salary, string $position)
    {
        parent::__construct($name, $age, $email);
        $this->salary = $salary;
        $this->position = $position;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getInfo(): string
    {
        $basicInfo = parent::getBasicInfo();
        return $basicInfo . " - Puesto: {$this->position}, Salario: $" . number_format($this->salary, 2);
    }

    public function calculateAnnualSalary(): float
    {
        return $this->salary * 12;
    }
}
