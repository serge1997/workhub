<?php
namespace App\Core\Bi\Repository;

interface BiRepositoryInterface
{

    public function countTaskBySprintProject(int $project_id);
    public function listTaskCompletedAndNotByProject(int $project_id);
    public function concludedAndNotBySprint(int $sprint_id);
    public function findAllMembersTaskByTeam(int $team_id);
}
