<?php

namespace DevChen\SwooleIM\Listeners\Open;

use DevChen\SwooleIM\Listeners\InterfaceListener;
use League\Event\AbstractEvent;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use swoole_websocket_server;
use swoole_http_request;

abstract class Listener extends AbstractListener implements InterfaceListener
{
    /**
     * @var swoole_websocket_server
     */
    protected $swooleWebSocketServer;

    /**
     * @var swoole_http_request
     */
    protected $swooleHttpRequest;

    public function handle(EventInterface $event, $param = null)
    {
        $this->swooleWebSocketServer = func_get_arg(1);
        $this->swooleHttpRequest = func_get_arg(2);
        return $this->execute($event);
    }
}