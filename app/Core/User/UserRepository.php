<?php
namespace App\Core\User;

use App\Models\User;
class UserRepository implements UserRepositoryInterface
{
    public function create($request)
    {
        User::create($request->validated());
    }
}
