<?php

namespace DevChen\SwooleIM\Listeners;

use League\Event\EventInterface;

interface InterfaceListener
{
    public function execute(EventInterface $event);
}