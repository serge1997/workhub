<?php

namespace App\Http\Controllers;

use App\Core\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Traits\HttpResponse;
use Exception;

class UserController extends Controller
{
    use HttpResponse;

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

    public function OnSearch(Request $request)
    {
        try{
            $users = UserResource::collection(
                $this->userRepositoryInterface->search($request)
            );
            return response()
                ->json($users);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function getByProject(int $project_id)
    {
        try{
            $message = "lista dos membros do projeto";
            $response = $this->userRepositoryInterface->listByProject($project_id);
            return response()
                ->json($this->successResponse($message, $response));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }


}
