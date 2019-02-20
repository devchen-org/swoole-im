<?php

namespace DevChen\SwooleIM\Listeners\Message;

use DevChen\SwooleIM\Listeners\InterfaceListener;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use swoole_websocket_server;
use swoole_websocket_frame;
use DevChen\SwooleIM\Services\RoomService;

abstract class Listener extends AbstractListener implements InterfaceListener
{
    /**
     * 是swoole_server对象
     *
     * @var swoole_websocket_server
     */
    protected $swooleWebSocketServer;

    /**
     * @var RoomService
     */
    protected $roomService;

    /**
     * 是swoole_websocket_frame对象，包含了客户端发来的数据帧信息
     * 客户端发送的ping帧不会触发onMessage，底层会自动回复pong包
     * onMessage回调必须被设置，未设置服务器将无法启动
     *
     * @var swoole_websocket_frame
     */
    protected $swooleWebSocketFrame;

    public function handle(EventInterface $event, $param = null)
    {
        $this->swooleWebSocketServer = func_get_arg(1);
        $this->swooleWebSocketFrame = func_get_arg(2);

        $this->roomService = new RoomService();

        return $this->execute($event);
    }
}