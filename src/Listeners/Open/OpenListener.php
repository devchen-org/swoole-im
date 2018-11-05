<?php

namespace DevChen\SwooleIM\Listeners\Open;

use League\Event\EventInterface;

class OpenListener extends Listener
{
    public function execute(EventInterface $event)
    {
        var_dump($event->getName() . $this->swooleHttpRequest->fd);
    }
}