<?php

namespace DevChen\SwooleIM\Providers;

use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;

class IMListenerProvider implements ListenerProviderInterface
{
    protected $map = [
        'im.open' => [
            \DevChen\SwooleIM\Listeners\Open\OpenListener::class,
        ],
        'im.request' => [

        ],
        'im.message' => [

        ],
        'im.close' => [
            \DevChen\SwooleIM\Listeners\Close\CloseListener::class,
        ],
    ];

    public function provideListeners(ListenerAcceptorInterface $listenerAcceptor)
    {
        foreach ($this->map as $name => $listeners) {
            foreach ($listeners as $listener) {
                $listenerAcceptor->addListener($name, new $listener);
            }
        }
    }

}