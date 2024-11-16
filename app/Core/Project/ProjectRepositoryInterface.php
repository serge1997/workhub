<?php
namespace App\Core\Project;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

interface ProjectRepositoryInterface
{
    public function create($request) : Project;
    public function findAll() ;
    public function findByName(string $name) : ?Project;
    public function find(int $id) : Project;
}
