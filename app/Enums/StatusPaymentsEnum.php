<?php

namespace App\Enums;

use App\Traits\GetsAttributes;

enum StatusPaymentsEnum: string
{
    use GetsAttributes;

    #[Description('Ожидание оплаты')]
    case PENDING_PAYMENT = 'pending';
    #[Description('Успешно оплачено')]
    case PAYMENT_SUCCESSFUL = 'successful';
    #[Description('Отменено')]
    case PAYMENT_CANCELLED = 'cancelled';
    #[Description('В обработке')]
    case PROCESSING = 'processing';
    #[Description('Ошибка оплаты')]
    case PAYMENT_ERROR = 'error';
    #[Description('Возврат')]
    case REFUNDED = 'refunded';
    #[Description('Завершено')]
    case COMPLETED = 'completed';
}
