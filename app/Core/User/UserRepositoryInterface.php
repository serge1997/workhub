<?php
namespace App\Core\User;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function create($request);
    public function listAll();
    public function createAvatar($request);
    public function search($request);
    public function listByProject(int $project_id);
    public function find(?int $id) : ?User;
}
