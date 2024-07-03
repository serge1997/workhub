<?php

namespace App\Http\Controllers;

use App\Core\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use Exception;

class UserController extends Controller
{
    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface
    )
    {}

    public function OnCreate(StoreUserRequest $request)
    {
        $request->validated();
        try{
            $message = "Usuario criado com successo";
            $this->userRepositoryInterface->create($request);
            return response()
                ->json($message);
        }catch(Exception $e) {
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function OnListAll()
    {
        try{
            return response()
                ->json($this->userRepositoryInterface->listAll());
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function OnCreateAvatar(Request $request)
    {
        try{
            $message = "Avatar salvou com successo";
            $this->userRepositoryInterface->createAvatar($request);
            return response()
                ->json($message);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function onUnreadNotification(Request $request)
    {
        try{
            $data = $this->userRepositoryInterface->unreadNotification($request);
            return response()
                ->json([
                    "notifications" => $data[0] ,
                    "count" => $data[1],
                ]);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
