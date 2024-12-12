<?php
namespace App\Core\Bi\Repository;

interface BiRepositoryInterface
{

    public function countTaskBySprintProject(int $project_id);
}
