<?php
namespace App\Core\TeamSpace\Actions;

use App\Core\TeamSpace\Repository\TeamSpaceRepositoryInterface;
use App\Http\Resources\TeamSpaceResource;

class TeamSpaceListAction
{
    public function __construct(
        private TeamSpaceRepositoryInterface $teamSpaceRepository
    ){}

    public function listAll()
    {
        return TeamSpaceResource::collection(
            $this->teamSpaceRepository->findAll()
        );
    }
    public function listById(int $id)
    {
        return new TeamSpaceResource(
            $this->teamSpaceRepository->find($id)
        );
    }
}
