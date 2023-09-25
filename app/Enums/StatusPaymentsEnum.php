<?php

namespace App\Enums;

use App\Traits\GetsAttributes;

enum StatusPaymentsEnum: string
{
    use GetsAttributes;

    #[Description('Заказ создан, но оплата еще не была завершена.')]
    case Pending_Payment = 'Ожидание оплаты ';
    #[Description('Оплата была успешно проведена, и средства были учтены.')]
    case Payment_Successful = 'Успешно оплачено ';
    #[Description('Оплата была отменена клиентом перед завершением.')]
    case Payment_Cancelled = 'Отменено';
    #[Description('Система обрабатывает платежную транзакцию.')]
    case Processing = 'В обработке';
    #[Description('Возникла ошибка в процессе оплаты, и платеж не был завершен.')]
    case Payment_Error = 'Ошибка оплаты';
    #[Description('Платеж был возвращен клиенту по какой-либо причине.')]
    case Refunded = 'Возврат';
    #[Description('Оплата была успешно проведена, и заказ завершен.')]
    case Completed = 'Завершено';
}
