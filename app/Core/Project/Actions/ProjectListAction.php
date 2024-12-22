<?php
namespace App\Core\Project\Actions;

use App\Core\Project\ProjectRepositoryInterface;

class ProjectListAction
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepository
    )
    {}

    public function listAllByTeamSpace(int $team_space_id)
    {
        return $this->projectRepository->findAllByTeamSpace($team_space_id);
    }
}
