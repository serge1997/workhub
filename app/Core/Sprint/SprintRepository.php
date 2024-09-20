<?php
namespace App\Core\Sprint;

use App\Models\Sprint;

class SprintRepository implements SprintRepositoryInterface
{
    public function create($request)
    {
        if ($request->has('name')) {
            $sprint = Sprint::create($request->validated());
            return $sprint;
        }
        return Sprint::create([
            'name' => 'Sprint '. $this->findLatest()->id + 1
        ]);

    }

    public function findLatest() : Sprint
    {
        return Sprint::latest()->first();
    }

    public function listAll()
    {

    }
}
