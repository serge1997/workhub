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
}
