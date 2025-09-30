<?php

namespace App\OOP\Contracts;

interface Identifiable
{
    public function getName(): string;
    public function getEmail(): string;
    public function getInfo(): string;
}
