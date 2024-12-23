<?php
namespace App\Core\TaskExecutionStatus\Actions;

use App\Core\TaskExecutionStatus\TaskExecutionStatusRepositoryInterface;

class TaskExceutionStatusListAction
{
    public function __construct(
        private TaskExecutionStatusRepositoryInterface $taskExecutionStatusRepository
    ){}

    public function listAllWithTaskCountByProject(int $project_id)
    {
        return $this->taskExecutionStatusRepository->findAllWithTaskCountByProject($project_id);
    }

    public function listAllCountBySprint(int $sprint_id)
    {
        return $this->taskExecutionStatusRepository->findAllCountBySprint($sprint_id);
    }

    public function listAllWithTaskCountByTeam(int $team_id)
    {
        return $this->taskExecutionStatusRepository->findAllWithTaskCountByTeam($team_id);
    }
}
