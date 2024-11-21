<?php
namespace App\Core\TeamSpace\Repository;

use App\Models\TeamSpace;

class TeamSpaceRepository implements TeamSpaceRepositoryInterface
{
    public function create($request)
    {
        return TeamSpace::create([
            'name' => $request->name(),
            'description' => $request->description(),
            'created_by' => $request->author()
        ]);
    }

    public function find(int $id)
    {
        return TeamSpace::find($id);
    }

    public function findAll()
    {
        return TeamSpace::all();
    }
    public function findByName(string $name) : ?TeamSpace
    {
        return TeamSpace::where('name', $name)->first();
    }
}
