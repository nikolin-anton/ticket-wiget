<?php

namespace App\Enum;

enum TicketStatusEnum: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case PROCESSED = 'processed';

    public function label()
    {
        return match ($this) {
            self::NEW => 'Open',
            self::IN_PROGRESS => 'In Progress',
            self::PROCESSED => 'Processed',
        };
    }
}
