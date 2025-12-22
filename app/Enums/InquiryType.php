<?php

namespace App\Enums;

enum InquiryType: string
{
    case NORMAL = 'normal';
    case URGENT = 'urgent';
    case EMERGENCY = 'emergency';

    public function label(): string
    {
        return match ($this) {
            self::NORMAL => 'Normal',
            self::URGENT => 'Urgent',
            self::EMERGENCY => 'Emergency',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
