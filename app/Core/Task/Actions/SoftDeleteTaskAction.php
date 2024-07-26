<?php
namespace App\Core\Task\Actions;

use App\Models\Task;
use Carbon\Carbon;

final class SoftDeleteTaskAction
{
    public function __construct(
        private readonly Task $task,
        protected readonly mixed $request
    )
    { }

    public function handle()
    {
        $this->task->update([
            'deleted_at' => Carbon::now()->isoFormat("Y-MM-DD H:mm:s")
        ]);
    }
}
