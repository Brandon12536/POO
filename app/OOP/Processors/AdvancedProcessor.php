<?php

namespace App\OOP\Processors;

use App\Exceptions\InvalidValueException;
use App\OOP\Abstracts\BaseProcessor;

class AdvancedProcessor extends BaseProcessor
{
    public function operate(string $value): string
    {
        if ($value === '') {
            throw new InvalidValueException('Valor inválido');
        }

        $formatted = parent::format($value);
        return $this->getName() . ':' . $formatted;
    }
}
