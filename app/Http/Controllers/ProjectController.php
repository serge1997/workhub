<?php

namespace App\Http\Controllers;

use App\Core\Project\ProjectRepositoryInterface;
use App\Http\Requests\ProjectRequest;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use HttpResponse;

    public function __construct(
        private ProjectRepositoryInterface $projectRepository
    )
    {}

    public function index()
    {
        try{
            $response = $this->projectRepository->findAll();
            return response()
                ->json($this->successResponse('lista de todos os projetos', $response));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }

    public function store(ProjectRequest $request)
    {
        try{
            $request->validated();
            $message = "Projeto criado com successo";
            $project = $this->projectRepository->create($request);
            return response()
                ->json($this->successResponse($message, $project));
        }catch(\Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }
}
