<?php
namespace App\Core\TeamSpace\Actions;

use App\Core\TeamSpace\Exception\TeamSpaceException;
use App\Core\TeamSpace\Repository\TeamSpaceRepositoryInterface;
use App\Http\Resources\TeamSpaceResource;
use Illuminate\Foundation\Http\FormRequest;

class TeamSpaceCreateAction
{
    public function __construct(
        private TeamSpaceRepositoryInterface $teamSpaceRepository
    ){}

    public function run(FormRequest $request): TeamSpaceResource
    {
        $exists = $this->teamSpaceRepository->findByName($request->name());
        if (!$exists){
            return new TeamSpaceResource(
                $this->teamSpaceRepository->create($request)
            );
        }
        throw new TeamSpaceException("Team space já existe");
    }
}
