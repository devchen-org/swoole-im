<?php

namespace DevChen\SwooleIM\Commands;

use Symfony\Component\Console\Command\Command as SymfonyConsole;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

abstract class Command extends SymfonyConsole
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var InputInterface
     */
    protected $input;

    public function __construct($name = null)
    {
        parent::__construct($name);

    }

    /**
     * @param $messages
     * @param int $options
     * @return mixed
     */
    protected function error($messages, $options = 0)
    {
        return $this->output->writeln(sprintf('<error>%s</error>', $messages), $options);
    }

    /**
     * @param $messages
     * @param int $options
     * @return mixed
     */
    protected function info($messages, $options = 0)
    {
        return $this->output->writeln(sprintf('<info>%s</info>', $messages), $options);
    }


    protected function getArgument($name)
    {
        return $this->input->getArgument($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->handle();
    }

    abstract function handle();

}