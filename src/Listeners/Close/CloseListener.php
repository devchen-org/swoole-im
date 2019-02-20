<?php

namespace DevChen\SwooleIM\Listeners\Close;

use League\Event\EventInterface;

class CloseListener extends Listener
{
    public function execute(EventInterface $event)
    {
        $fd = $this->roomService->getFd($this->fd);
        $room_id = $fd['room_id'];

        $this->roomService->quitRoom($room_id, $this->fd);
        $this->roomService->delFd($this->fd);

    }

}