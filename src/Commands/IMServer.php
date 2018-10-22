<?php

namespace DevChen\SwooleIM\Commands;

use DevChen\SwooleIM\Services\IMService;
use Symfony\Component\Console\Input\InputArgument;

class IMServer extends Command
{
    /**
     * @var IMService
     */
    protected $imService;


    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->imService = new IMService();
    }

    protected function configure()
    {
        $this->setName('im:server')
            ->addArgument('action', InputArgument::REQUIRED, 'start|stop|reload ?')
            ->setDescription('Operate IM server.');
    }

    public function handle()
    {
        $action = $this->getArgument('action');

        switch ($action) {
            case 'start':
                $this->start();
                break;
            case 'stop':
                $this->stop();
                break;
            case 'reload':
                $this->reload();
                break;
            default :

                break;
        }
    }

    protected function start()
    {
        if ($this->imService->isRunning()) {
            return $this->error('IM server is already running.');
        }
        $this->imService->start() ?
            $this->info('IM server start success.') :
            $this->error('IM server start failed.');
    }


    protected function stop()
    {
        if (!$this->imService->isRunning()) {
            return $this->error('IM server has stopped.');
        }
        $this->imService->stop() ?
            $this->info('IM server stop success.') :
            $this->error('IM server stop failed.');
    }

    protected function reload()
    {
        if (!$this->imService->isRunning()) {
            return $this->error('IM server has stopped.');
        }
        $this->imService->reload() ?
            $this->info('IM server reload success.') :
            $this->error('IM server reload failed.');;
    }
}