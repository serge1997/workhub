<?php
namespace App\Core\User;

use App\Core\User\Actions\UserListAction;
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
            if (!is_null($oldUserAvatar)) unlink("img/users_avatars/{$oldUserAvatar}");

        }
    }

    public function search($request)
    {
       /** @var UserListAction $userListAction */
       $userListAction = app(UserListAction::class);
       return $userListAction->searchByName($request);
    }

    public function listByProject(int $project_id)
    {
        return UserResource::collection(
            User::whereIn('id', function($query) use($project_id){
                $query->select('user_id')
                    ->from('tasks')
                        ->where([['project_id', $project_id], ['deleted_at', null]]);
            })->get()
        );
    }

    public function find(?int $id) : ?User
    {
        return User::find($id);
    }
    public function findAllByTeam(int $team_id)
    {
        return User::where('team_id', $team_id)
            ->get();
    }
}
