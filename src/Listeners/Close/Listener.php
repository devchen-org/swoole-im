<?php

namespace DevChen\SwooleIM\Listeners\Close;

use DevChen\SwooleIM\Listeners\InterfaceListener;
use League\Event\AbstractEvent;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use swoole_websocket_server;

abstract class Listener extends AbstractListener implements InterfaceListener
{
    /**
     * 是swoole_server对象
     *
     * @var swoole_websocket_server
     */
    protected $swooleWebSocketServer;

    /**
     * 来自那个reactor线程
     *
     * @var
     */
    protected $reactorId;

    /**
     * 是连接的文件描述符
     *
     * @var
     */
    protected $fd;

    public function handle(EventInterface $event, $param = null)
    {
        $this->swooleWebSocketServer = func_get_arg(1);
        $this->fd = func_get_arg(2);
        $this->reactorId = func_get_arg(3);
        return $this->execute($event);
    }
}