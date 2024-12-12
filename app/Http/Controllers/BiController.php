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
                ->json($this->successResponse($e->getMessage()));
        }
    }
}
