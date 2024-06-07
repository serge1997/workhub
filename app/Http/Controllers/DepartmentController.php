<?php

namespace App\Http\Controllers;

use App\Core\Department\DepartmentRepositoryInterface;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepositoryInterface
    )
    {}

    public function OnListAll()
    {
        try{
            return response()
                ->json($this->departmentRepositoryInterface->listAll());
        }catch(\Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
