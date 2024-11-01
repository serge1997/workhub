<?php
namespace App\Core\Project;

use App\Core\Project\Exception\ProjectException;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function create($request) : Project
    {
        if ($this->findByName($request->name)) {
            throw new ProjectException("projeto já existe");
        }
        return Project::create($request->all());
    }

    public function findAll()
    {
        return ProjectResource::collection(
            Project::all()
        );
    }
    public function findByName(string $name) : ?Project
    {
        return Project::where("name", $name)->first();
    }
}
