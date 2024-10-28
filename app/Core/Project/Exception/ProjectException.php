<?php
namespace App\Core\Project\Exception;

class ProjectException extends \Exception
{
    public function __construct($message = "", $code = 500)
    {
        parent::__construct($message, $code);
    }
}
