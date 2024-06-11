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

    public function createAvatar($request)
    {
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()){
            $user = $request->user();
            $oldUserAvatar = $user->avatar;
            $avatar = $request->avatar;
            $extension = $avatar->extension();
            $avatarName = md5($avatar->getClientOriginalName() . strtotime('now')) . "." . $extension;
            $avatar->move(public_path('img/users_avatars'), $avatarName);
            $user->update([
                'avatar' => $avatarName
            ]);
            unlink("img/users_avatars/{$oldUserAvatar}");
        }
    }
}
