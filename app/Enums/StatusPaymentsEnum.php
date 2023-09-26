<?php

namespace App\Enums;

use App\Traits\GetsAttributes;

enum StatusPaymentsEnum: string
{
    use GetsAttributes;

    #[Description('Ожидание оплаты')]
    case PENDING_PAYMENT = 'pending payment';
    #[Description('Успешно оплачено')]
    case PAYMENT_SUCCESSFUL = 'payment successful';
    #[Description('Отменено')]
    case PAYMENT_CANCELLED = 'payment cancelled';
    #[Description('В обработке')]
    case PROCESSING = 'processing';
    #[Description('Ошибка оплаты')]
    case PAYMENT_ERROR = 'payment error';
    #[Description('Возврат')]
    case REFUNDED = 'refunded';
    #[Description('Завершено')]
    case COMPLETED = 'completed';
}
