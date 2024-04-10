<?php

namespace App\Enums;

enum AccountType: int
{
    case ContaCorrente = 1;
    case ContaPoupanca = 2;
    case ContaInvestimento = 3;

    public function label(): string
    {
        return match ($this) {
            self::ContaCorrente => 'Conta Corrente',
            self::ContaPoupanca => 'Conta Poupança',
            self::ContaInvestimento => 'Conta Investimento',
        };
    }

    public function color(): string
    {
        return match ($this) {
            // self::ContaCorrente => 'text-green-600',
            // self::ContaPoupanca => 'text-orange-600',
            // self::ContaInvestimento => 'text-blue-600',
            self::ContaCorrente => 'bg-green-600',
            self::ContaPoupanca => 'bg-orange-600',
            self::ContaInvestimento => 'bg-blue-600',
        };
    }

    public function labelPowergridFilter(): string
    {
        return $this->label();
    }
}
