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

    public function OnListAll()
    {
        try{
            return response()
                ->json($this->positionRepositoryInterface->listAll());
        }catch(\Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
