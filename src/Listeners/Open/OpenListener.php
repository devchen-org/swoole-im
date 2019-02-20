<?php

namespace DevChen\SwooleIM\Listeners\Open;

use League\Event\EventInterface;

class OpenListener extends Listener
{
    public function execute(EventInterface $event)
    {
        $this->roomService->setFd($this->swooleHttpRequest->fd, [
            'room_id' => $this->roomId
        ]);
        $this->roomService->joinRoom($this->roomId, $this->swooleHttpRequest->fd);
    }
}