<?php
namespace App\Core\TeamSpace\Exception;

class TeamSpaceException extends \Exception
{
    public function __construct(string $message = "", int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
