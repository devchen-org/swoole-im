<?php

namespace DevChen\SwooleIM\Services;

use DevChen\SwooleIM\Helpers\Config;
use swoole_websocket_server;
use swoole_websocket_frame;
use swoole_process;

class IMService
{
    /**
     * @var swoole_websocket_server
     */
    protected $swooleWebSocketServer;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var int
     */
    protected $pid;


    /**
     * @var array
     */
    protected $config;

    public function __construct()
    {
        $this->config = Config::all();
        $this->host = $this->config['host'];
        $this->port = $this->config['port'];
        $pid_file = $this->config['pid_file'];

        if (!file_exists($pid_file)) {
            touch($pid_file);
        }
        $this->pid = intval(file_get_contents($pid_file));

    }

    /**
     * @return bool
     */
    public function start()
    {
        $this->swooleWebSocketServer = new swoole_websocket_server($this->host, $this->port);
        $this->swooleWebSocketServer->set($this->config);

        $this->swooleWebSocketServer->on('open', [$this, 'open']);
        $this->swooleWebSocketServer->on('message', [$this, 'message']);
        $this->swooleWebSocketServer->on('request', [$this, 'request']);
        $this->swooleWebSocketServer->on('close', [$this, 'close']);

        return $this->swooleWebSocketServer->start();
    }

    public function open(swoole_websocket_server $swooleWebSocketServer, $request)
    {

    }

    public function request($request, $response)
    {

    }

    public function message(swoole_websocket_server $swooleWebSocketServer, swoole_websocket_frame $swooleWebSocketFrame)
    {

    }

    public function close($ser, $fd)
    {

    }

    /**
     * @return bool
     */
    public function reload()
    {
        if (empty($this->pid)) {
            return false;
        }
        return swoole_process::kill($this->pid, SIGUSR1);
    }

    /**
     * @return bool
     */
    public function stop()
    {
        if (empty($this->pid)) {
            return true;
        }
        return swoole_process::kill($this->pid, SIGTERM);
    }

    /**
     * @return bool
     */
    public function isRunning()
    {
        if (empty($this->pid)) {
            return false;
        }
        return swoole_process::kill($this->pid, 0);
    }
}