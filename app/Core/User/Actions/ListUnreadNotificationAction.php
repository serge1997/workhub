<?php
namespace App\Core\User\Actions;

use React\EventLoop\Loop;

final class ListUnreadNotificationAction
{

    public function get($request) : array
    {

        $collections = $request->user()->unreadNotifications->map(function($notif, $key) use($request){
            $notif->created_formated = date('d/m/Y H:i', strtotime($notif->created_at));
            $data = json_decode(json_encode($notif->data));
            if($data->user_id === $request->user()->id && !is_null($key)){
                return $notif;
            }
            //return null;
        });
        return [
            $collections,
            count($collections)
            //$request->user()->unreadNotifications->count() ?? 0
        ];
    }
}
