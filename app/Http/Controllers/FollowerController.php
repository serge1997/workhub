<?php

namespace App\Http\Controllers;

use App\Core\Follower\FollowerRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function __construct(
        protected FollowerRepositoryInterface $followerRepositoryInterface
    ){}

    public function onListAllByTask(Request $request)
    {
        try{
            return response()
                ->json(
                    $this->followerRepositoryInterface->listAllByTask($request)
                );
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
