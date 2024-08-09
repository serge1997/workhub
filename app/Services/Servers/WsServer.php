<?php
namespace App\Services\Servers;

use WebSocket\Client;

class WsServer
{
    private Client $server;

    public function __construct(
        private readonly string $url
    )
    {
        $this->server = new Client($url);
    }

    public function notify($data) : void
    {
        $data = json_decode($data);
        $this->server->send($data);
    }
}
