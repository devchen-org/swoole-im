<?php

namespace DevChen\SwooleIM\Commands;

use DevChen\SwooleIM\Services\IMService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

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

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $action = $input->getArgument('action');

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
        $this->imService->start();
    }


    protected function stop()
    {
        $this->imService->stop();
    }

    protected function reload()
    {

    }
}