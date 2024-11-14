<?php

namespace App\Http\Controllers;

use App\Core\Sprint\Actions\SprintListAction;
use App\Core\Sprint\SprintRepositoryInterface;
use App\Http\Requests\SprintRequest;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;
use Psr\Container\ContainerInterface;

class SprintController extends Controller
{
    use HttpResponse;

    public function __construct(
        private readonly SprintRepositoryInterface $sprintRepositoryInterface,
        private ContainerInterface $container
    )
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

    public function getAllByProject(int $project_id)
    {
        try{
            /** @var SprintListAction $sprintListAction */
            $sprintListAction = $this->container->get(SprintListAction::class);
            $response = $sprintListAction->listBAllBySprint($project_id);
            return response()
                ->json($this->successResponse('lista dos sprints por projetos', $response));

        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }
}
