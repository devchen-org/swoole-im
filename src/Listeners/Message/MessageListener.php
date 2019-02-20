<?php

namespace DevChen\SwooleIM\Listeners\Message;

use League\Event\EventInterface;

class MessageListener extends Listener
{
    public function execute(EventInterface $event)
    {
        $fd = $this->roomService->getFd($this->swooleWebSocketFrame->fd);

        $room_id = $fd['room_id'];
        $room = $this->roomService->getRoom($room_id);

        foreach ($room as $r) {
            if ($r != $this->swooleWebSocketFrame->fd) {
                $this->swooleWebSocketServer->push($r, $this->swooleWebSocketFrame->data);
            }
        }
    }

}