<?php

namespace App\Enums;

enum OrderStatus: string
{
    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';

    const WAITING     = 'waiting';
    const ASSIGNED    = 'assigned';
    const IN_SERVICE  = 'in_service';
    const DONE        = 'done';
    const OPEN        = 'open';
    const PAID        = 'paid';
    const VOID        = 'void';

    const SERVICE        = 'service';
    const ADDON        = 'add_on';
}
