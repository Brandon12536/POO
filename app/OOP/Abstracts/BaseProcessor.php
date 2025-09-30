<?php

namespace App\OOP\Abstracts;

use App\OOP\Contracts\Operable;

abstract class BaseProcessor implements Operable
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function format(string $value): string
    {
        return strtoupper(trim($value));
    }

    abstract public function operate(string $value): string;
}
