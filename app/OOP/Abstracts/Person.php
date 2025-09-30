<?php

namespace App\OOP\Abstracts;

use App\OOP\Contracts\Identifiable;

abstract class Person implements Identifiable
{
    protected string $name;
    protected int $age;
    protected string $email;

    public function __construct(string $name, int $age, string $email)
    {
        $this->name = $name;
        $this->age = $age;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    protected function getBasicInfo(): string
    {
        return "{$this->name} ({$this->age} años) - {$this->email}";
    }

    abstract public function getInfo(): string;
}
