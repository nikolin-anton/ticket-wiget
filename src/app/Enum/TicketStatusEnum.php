<?php

namespace App\Enum;

enum TicketStatusEnum: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case PROCESSED = 'processed';
}
