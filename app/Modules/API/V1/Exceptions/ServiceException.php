<?php

namespace Modules\API\V1\Exceptions;

use Exception;

class ServiceException extends Exception
{

    public function __construct(string $message = 'Неизвестная ошибка')
    {
        parent::__construct($message);
    }

}
