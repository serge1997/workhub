<?php
namespace App\Core\User\Actions;

use App\Core\User\UserRepositoryInterface;
use App\Http\Resources\UserResource;
use App\Models\User;

final class UserListAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function searchByName($request)
    {
        $param = str_replace('@', '', $request->user_name);
        return User::whereRaw("name LIKE '%{$param}%'")
            ->get();
    }

    public function listAllByTeam(int $team_id)
    {
        return UserResource::collection(
            $this->userRepository->findAllByTeam($team_id)
        );
    }
}
