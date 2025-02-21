<?php

namespace App\Models\Enums;

enum Status: string
{
    case New = 'new';
    case Completed = 'completed';

    public function getStatusName(): string
    {
        return match ($this) {
            static::New => 'Новый',
            static::Completed => 'Выполнен',

        };
    }
}
