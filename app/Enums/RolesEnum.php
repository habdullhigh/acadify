<?php

namespace App\Enums;

enum RolesEnum: string
{
    const STUDENT = "student";
    const ADMIN = "admin";

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
