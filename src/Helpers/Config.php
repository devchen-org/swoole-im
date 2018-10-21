<?php

namespace DevChen\SwooleIM\Helpers;

use Noodlehaus\Config as NoodlehausConfig;

class Config
{
    /**
     * @var NoodlehausConfig
     */
    protected static $config = null;

    protected function __construct()
    {

    }

    protected function __clone()
    {

    }

    public static function get($key, $default = null)
    {
        return self::getInstance()->get($key, $default);
    }

    public static function all()
    {
        return self::getInstance()->all();
    }

    protected static function getInstance()
    {
        if (self::$config === null) {
            self::$config = new NoodlehausConfig(__DIR__ . '/../../config');
        }
        return self::$config;
    }
}