<?php
namespace App\Core\User\Actions;

use React\EventLoop\Loop;

final class ListUnreadNotificationAction
{

    public function get($request) : array
    {
        $loop = Loop::get();
        $data = [];
        $timer = $loop->addPeriodicTimer(2, function() use($data, $request){
            $collections = $request->user()->unreadNotifications->map(function ($notif){
                $notif->created_formated = date('d/m/Y H:i', strtotime($notif->created_at));
                return $notif;
            });
            $data[] = $collections;
        });

        $loop->addTimer(2, function() use($loop, $timer){
            $loop->cancelTimer($timer);
            echo "Done";
        });
        $data[] = $request->user()->unreadNotifications->count();
        return $data;
        $loop->run();
    }
}
