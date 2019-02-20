<?php

namespace DevChen\SwooleIM\Helpers;

use Predis\Client;

class Redis
{
    protected static $instance = null;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            $config = Config::all();
            self::$instance = new Client($config['redis']);
        }
        return self::$instance;
    }

    private function __clone()
    {

    }
}