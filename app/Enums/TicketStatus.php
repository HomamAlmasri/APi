<?php

namespace App\Enums;

enum TicketStatus: string
{
    case A = 'A';
    case B = 'B';
    case C = 'C';
    case D = 'D';
    case E = 'E';

    public static function values(): array
    {
//    dd(self::cases(),array_column(self::cases(), 'value'));
        return array_column(self::cases(), 'value');
    }
}

