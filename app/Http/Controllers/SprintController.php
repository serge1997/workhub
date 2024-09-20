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
        //dd($request->validated());
        try{
            $request->validated();
            $message = "Sprint created successfully";
            $this->sprintRepositoryInterface->create($request);
            return response()
                ->json($message);
        }catch(Exception $e){
            return response()
                ->json($e->getMessage(), 500);
        }
    }
}
