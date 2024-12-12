<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Psr\Container\ContainerInterface;

class BiController extends Controller
{
    use HttpResponse;

    public function __construct(
        private readonly ContainerInterface $container
    ){}
}
