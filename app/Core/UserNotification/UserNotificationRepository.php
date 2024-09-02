<?php
namespace App\Core\UserNotification;

use App\Models\TaskActivity;

class UserNotificationRepository implements UserNotificationRepositoryInterface
{

    public function create(array $users, TaskActivity $activity) : void
    {
        //save followers related task -> task_activity_id related user_id
        //save manager related task -> task_activity_id related user_id
        //save user resposable -> task_activity_id related user_id

    }
}
