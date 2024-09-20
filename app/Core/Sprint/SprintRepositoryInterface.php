<?php
namespace App\Core\Sprint;

use App\Models\Sprint;

interface SprintRepositoryInterface
{
    public function create($request);
    public function listAll();
    public function findLatest() : Sprint;
}
