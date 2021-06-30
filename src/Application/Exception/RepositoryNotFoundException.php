<?php

declare(strict_types=1);

namespace App\Application\Exception;

class RepositoryNotFoundException extends ApplicationException
{
    public function __construct($message = "")
    {
        parent::__construct($message, 404);
    }
}