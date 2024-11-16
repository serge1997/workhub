<?php
namespace App\Core\Sprint\Actions;

use App\Core\Project\ProjectRepositoryInterface;
use App\Core\Sprint\SprintRepositoryInterface;
use App\Http\Resources\SprintResource;

final class SprintListAction
{
    public function __construct(
        private SprintRepositoryInterface $sprintRepository,
        private ProjectRepositoryInterface $projectRepository
    ) {}

    public function listBAllBySprint(int $project_id)
    {
        $project = $this->projectRepository->find($project_id);
        return $this->sprintRepository->findAllByProject($project);

    }
}
