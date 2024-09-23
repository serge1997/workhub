<?php
namespace App\Core\Sprint;

use App\Http\Resources\SprintResource;
use App\Models\Sprint;

class SprintRepository implements SprintRepositoryInterface
{
    public function create($request)
    {
        if ($request->has('name')) {
            $sprint = Sprint::create($request->validated());
            return $sprint;
        }

        if ($request->generate() === true){
            return Sprint::create([
                'name' => 'Sprint '. $this->findLatest()->id + 1
            ]);
        }


    }

    public function findLatest() : Sprint
    {
        return Sprint::latest()->first();
    }

    public function listAll()
    {
        return SprintResource::collection(Sprint::all());
    }
}
