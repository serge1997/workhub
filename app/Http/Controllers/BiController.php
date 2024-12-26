<?php

namespace App\Http\Controllers;

use App\Core\Bi\Repository\BiRepositoryInterface;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;
use Psr\Container\ContainerInterface;

class BiController extends Controller
{
    use HttpResponse;

    public function __construct(
        private readonly BiRepositoryInterface $biRepository
    ){}

    public function listCountTaskbySprintsProject(int $project_id)
    {
        try{
            return response()
                ->json(
                    $this->biRepository->countTaskBySprintProject($project_id)
                );
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse($e->getMessage()));
        }
    }

    public function listTaskExcutionStatusByProjectSprint($project_id)
    {
        try{
            return response()
                ->json($this->successResponse(
                    "relatorio tarefa concluidas S/N por projeto e sprint", $this->biRepository->listTaskCompletedAndNotByProject($project_id)
                ));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse($e->getMessage()));
        }
    }

    public function listConcludedAndNot(int $sprint_id)
    {
        try{
            return response()
                ->json($this->successResponse(
                    "relatorio tarefa concluidas S/N por sprint", $this->biRepository->concludedAndNotBySprint($sprint_id)
                ));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse($e->getMessage()));
        }
    }

    public function listTeamMembersTaskByTeam(int $team_id)
    {
        try{
            return response()
                ->json($this->successResponse(
                    "list user task (concluded&not) and tasks",
                    $this->biRepository->findAllMembersTaskByTeam($team_id)
                ));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse($e->getMessage()));
        }
    }
}
