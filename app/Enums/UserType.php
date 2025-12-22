<?php
namespace App\Enums;

enum UserType: string {
    case CUSTOMER       = 'customer';
    case SUPPLIER       = 'supplier';
    case REPRESENTATIVE = 'representative';

    public function label(): string
    {
        return match ($this) {
            self::CUSTOMER       => 'Customer',
            self::SUPPLIER       => 'Supplier',
            self::REPRESENTATIVE => 'Representative',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
