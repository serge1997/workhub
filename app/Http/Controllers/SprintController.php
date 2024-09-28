<?php

namespace App\Http\Controllers;

use App\Core\Sprint\SprintRepositoryInterface;
use App\Http\Requests\SprintRequest;
use Exception;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    public function __construct(private readonly SprintRepositoryInterface $sprintRepositoryInterface)
    {}

    public function onCreate(SprintRequest $request)
    {
        try{
            $message = "Sprint created successfully";

            if ($request->has('generate')){
                $data = $this->sprintRepositoryInterface->create($request);
            }
            if ($request->has('name')){
                $request->validated();
                $data = $this->sprintRepositoryInterface->create($request);
            }
            return response()
                ->json(['data' => $data, 'message' => $message]);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }

    public function onListAll()
    {
        try{
            return response()
                ->json($this->sprintRepositoryInterface->listAll());
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
