<?php
namespace App\Core\Sprint;

use App\Models\Sprint;
use App\Models\Project;

interface SprintRepositoryInterface
{
    public function create($request);
    public function listAll();
    public function findLatest() : ?Sprint;
    public function findAllByProject(Project $project);
}
