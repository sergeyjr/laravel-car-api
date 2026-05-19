<?php

namespace App\Enums;

enum DeliveryStatus: string
{

    case NEW = 'new';

    case IN_TRANSIT = 'in_transit';

    case DELIVERED = 'delivered';

}
