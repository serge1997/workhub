<?php
namespace App\Core\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\UserResource;
class UserRepository implements UserRepositoryInterface
{
    public function create($request)
    {
        $user = new User($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
    }
    public function listAll()
    {
        return UserResource::collection(User::all());
    }
}
