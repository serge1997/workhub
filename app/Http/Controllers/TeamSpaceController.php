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
        }catch(Exception $e){
            return response()
                ->json($this->errorResponse("Error: {$e->getMessage()}"), 500);
        }
    }

    public function store(TeamSpaceRequest $request)
    {
        try{
            /** @var TeamSpaceCreateAction $teamCreateAction */
            $teamCreateAction = $this->container->get(TeamSpaceCreateAction::class);
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
