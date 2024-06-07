<?php

namespace App\Http\Controllers;

use App\Core\Position\PositionRepositoryInterface;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function __construct(
        private PositionRepositoryInterface $positionRepositoryInterface
    )
    {}
}
