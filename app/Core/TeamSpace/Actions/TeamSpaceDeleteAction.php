<?php
namespace App\Core\TeamSpace\Actions;

use App\Core\TeamSpace\Repository\TeamSpaceRepositoryInterface;

class TeamSpaceDeleteAction
{
    public function __construct(
        private TeamSpaceRepositoryInterface $teamSpaceRepository
    ){}

    public function run(int $id)
    {

    }
}
