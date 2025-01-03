<?php
namespace App\Core\TaskExecutionStatus;

interface TaskExecutionStatusRepositoryInterface
{
    public function create($request);
    public function listAll();
    public function find($request);
    public function update($request);
    public function delete($request);
    public function findAllWithTaskCountByProject(int $project_id);
    public function findAllCountBySprint(int $sprint_id);
    public function findAllWithTaskCountByTeam(int $team_id);
}
