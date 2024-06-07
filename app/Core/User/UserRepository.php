<?php
namespace App\Core\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function create($request)
    {
        $user = new User($request->validated());
        $user->password = Hash::make($request->password);
        $user->save();
    }
}
