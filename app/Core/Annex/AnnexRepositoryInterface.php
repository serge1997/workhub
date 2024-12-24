<?php
namespace App\core\Annex;

use App\Models\Annex;
use App\Models\Task;

interface AnnexRepositoryInterface
{
    public function create($request, ?Task $task = null);
    public function find($request);
    public function update($request);
    public function delete(Annex $annex);
}
