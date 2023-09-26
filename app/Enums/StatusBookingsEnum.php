<?php

namespace App\Enums;

use App\Traits\GetsAttributes;

enum StatusBookingsEnum: string
{
    use GetsAttributes;

    #[Description('Активно')]
    case ACTIVE = 'active';
    #[Description('Отменено')]
    case CANCELLED = 'cancelled';
    #[Description('Подтверждено')]
    case CONFIRMED = 'confirmed';
    #[Description('Отказ')]
    case DECLINED = 'declined';
    #[Description('Ожидание оплаты')]
    case PENDING_PAYMENT = 'pending payment';
    #[Description('Завершено')]
    case COMPLETED = 'completed';
    #[Description('Истекший')]
    case EXPIRED = 'expired';
}
