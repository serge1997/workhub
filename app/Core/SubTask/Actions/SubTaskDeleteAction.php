<?php
namespace App\Core\SubTask\Actions;

use App\Core\SubTask\Repository\SubTaskRepositoryInterface;
use App\Http\Resources\SubTaskResource;

class SubTaskDeleteAction
{
    public function __construct(
        private SubTaskRepositoryInterface $subTaskRepository
    ){}

    public function detach(int $id)
    {
        return new SubTaskResource(
            $this->subTaskRepository->detachSubTask(
                $this->subTaskRepository->findBySubTaskId($id)
            )
        );
    }
}
