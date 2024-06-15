<?php

namespace App\Http\Controllers;

use App\Core\Follower\FollowerRepositoryInterface;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function __construct(
        protected FollowerRepositoryInterface $followerRepositoryInterface
    ){}
}
