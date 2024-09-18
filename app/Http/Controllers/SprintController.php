<?php

namespace App\Http\Controllers;

use App\Core\Sprint\SprintRepositoryInterface;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    public function __construct(private readonly SprintRepositoryInterface $sprintRepositoryInterface)
    {}
}
