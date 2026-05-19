<?php

namespace App\Enums;

enum PaymentMethod: string
{

    case CARD = 'card';

    case CASH = 'cash';

    case PAYPAL = 'paypal';

}
