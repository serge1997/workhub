<?php
namespace App\Enums;

use App\Utilities\DocAttribute;

enum TaskExecutionStatusEnum : string
{
    #[DocAttribute(description: "Waiting")]
    case WAT = "WAT";
    #[DocAttribute(description: "IN PROGRESS")]
    case PRO = "PRO";
    #[DocAttribute(description: "CODE REVIEW")]
    case CDR = "CDR";
    #[DocAttribute(description: "CONCLUDED")]
    case CON = "CON";
    #[DocAttribute(description: "TESTE")]
    case TST = "TST";
    #[DocAttribute(description: "BACKLOG")]
    case BKL = "BKL";
    #[DocAttribute(description: "PULL REQUEST")]
    case PRQ = "PRQ";
    case BLOCK = "BLOCK";

    public function taskActivites()
    {

    }
}
