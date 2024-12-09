<?php
namespace App\Core\SubTask\Exception;


class SubTaskException extends \Exception
{
    public function __construct(string $message = "", int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
