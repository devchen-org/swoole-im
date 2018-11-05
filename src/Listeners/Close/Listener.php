<?php

namespace DevChen\SwooleIM\Listeners\Close;

use DevChen\SwooleIM\Listeners\InterfaceListener;
use League\Event\AbstractEvent;
use League\Event\AbstractListener;
use League\Event\EventInterface;

abstract class Listener extends AbstractListener implements InterfaceListener
{
    /**
     * @var
     */
    protected $ser;

    /**
     * @var
     */
    protected $fd;

    public function handle(EventInterface $event, $param = null)
    {
        $this->ser = func_get_arg(1);
        $this->fd = func_get_arg(2);
        return $this->execute($event);
    }
}