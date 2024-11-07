<?php
namespace App\Core\User\Actions;

use App\Models\User;

final class UserListAction
{

    public function searchByName($request)
    {
        $param = str_replace('@', '', $request->user_name);
        return User::whereRaw("name LIKE '%{$param}%'")
            ->get();
    }
}
