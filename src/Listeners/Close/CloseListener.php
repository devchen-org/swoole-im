<?php

namespace DevChen\SwooleIM\Listeners\Close;

use League\Event\EventInterface;

class CloseListener extends Listener
{
    public function execute(EventInterface $event)
    {
        var_dump($event->getName() . $this->fd);
    }

}