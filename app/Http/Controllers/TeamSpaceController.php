<?php

namespace App\Http\Controllers;

use App\Core\TeamSpace\Actions\TeamSpaceCreateAction;
use App\Core\TeamSpace\Actions\TeamSpaceDeleteAction;
use App\Core\TeamSpace\Actions\TeamSpaceListAction;
use App\Core\TeamSpace\Actions\TeamSpaceUpdateAction;
use App\Http\Requests\TeamSpaceRequest;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;
use Psr\Container\ContainerInterface;

class TeamSpaceController extends Controller
{
    use HttpResponse;

    public function __construct(
        private ContainerInterface $container
    ){}

    public function index()
    {
        try{
            /** @var TeamSpaceListAction $teamSpaceListAction */
            $teamSpaceListAction = $this->container->get(TeamSpaceListAction::class);
            $teams_spaces = $teamSpaceListAction->listAll();
            return response()
                ->json($this->successResponse('lista dos teams', $teams_spaces));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }

    public function store(TeamSpaceRequest $request)
    {
        try{
            /** @var TeamSpaceCreateAction $teamCreateAction */
            $request->setCreatedBy($request->user()->id);
            $teamCreateAction = $this->container->get(TeamSpaceCreateAction::class);
            $response = $teamCreateAction->run($request);
            return response()
                ->json($this->successResponse("Team criado com successo", $response));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }
    public function show(int $id)
    {
        try{
            /** @var TeamSpaceListAction $teamSpaceListAction */
            $teamSpaceListAction = $this->container->get(TeamSpaceListAction::class);
            $response = $teamSpaceListAction->listById($id);
            return response()
                ->json($this->successResponse("listando o team id: {$id}", $response));
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 404);
        }
    }

    public function update(TeamSpaceRequest $request)
    {
        try{
            /** @var TeamSpaceUpdateAction $teamSpaceUpdateAction */
            $teamSpaceUpdateAction = $this->container->get(TeamSpaceUpdateAction::class);
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }

    public function delete(int $id)
    {
        try{
            /** @var TeamSpaceDeleteAction $teamSpaceDeleteAction */
            $teamSpaceDeleteAction = $this->container->get(TeamSpaceDeleteAction::class);
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }
}
