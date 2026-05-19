<?php

namespace App\Enums;

enum OrderStatus: string
{

    // Ожидает оплаты
    case PendingPayment = 'pending_payment';

    // В обработке
    case Processing = 'processing';

    // Собран
    case Packed = 'packed';

    // Отправлен
    case Shipped = 'shipped';

    // Завершён
    case Completed = 'completed';

    // Отменён
    case Cancelled = 'cancelled';

    // Возврат
    case Refunded = 'refunded';

}
