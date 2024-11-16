<?php
namespace App\Core\Project\Actions;

use App\Core\Project\ProjectRepositoryInterface;

class ProjectListAction
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepository
    )
    {}
}
