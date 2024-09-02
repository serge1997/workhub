<?php
namespace App\Core\UserNotification;

use App\Models\TaskActivity;

interface UserNotificationRepositoryInterface
{

    public function create(array $users, TaskActivity $activity) : void;
}
