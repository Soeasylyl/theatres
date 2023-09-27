<?php

namespace App\Enums;

use App\Contracts\EnumInterface;
use App\Traits\EnumFromName;
use App\Traits\GetsAttributes;

enum StatusBookingsEnum: string implements EnumInterface
{
    use GetsAttributes, EnumFromName;

    #[Description('Активно')]
    case ACTIVE = 'active';
    #[Description('Отменено')]
    case CANCELLED = 'cancelled';
    #[Description('Подтверждено')]
    case CONFIRMED = 'confirmed';
    #[Description('Отказ')]
    case DECLINED = 'declined';
    #[Description('Ожидание оплаты')]
    case PENDING_PAYMENT = 'pending';
    #[Description('Завершено')]
    case COMPLETED = 'completed';
    #[Description('Истекший')]
    case EXPIRED = 'expired';
}
