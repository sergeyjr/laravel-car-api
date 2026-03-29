<?php

namespace Modules\API\V1\Exceptions;

use Exception;

class RepositoryException extends Exception
{

    public function __construct(string $message = 'Unknown exception')
    {
        parent::__construct($message);
    }

}
