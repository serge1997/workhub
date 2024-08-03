<?php
namespace App\Utilities;

use Attribute;

#[Attribute(Attribute::TARGET_ALL)]
class DocAttribute
{

    public function __construct(
        public ?string $description
    )
    {}
}
