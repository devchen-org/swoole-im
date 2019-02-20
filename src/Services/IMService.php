<?php

namespace DevChen\SwooleIM\Services;

use DevChen\SwooleIM\Helpers\Config;
use DevChen\SwooleIM\Providers\IMListenerProvider;
use League\Event\Emitter;
use swoole_websocket_server;
use swoole_websocket_frame;
use swoole_process;
use swoole_http_request;
use swoole_http_response;

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
     * @var Emitter
     */
    protected $emitter;

    /**
     * @var array
     */
    protected $config;

    public function __construct()
    {
        $config = Config::all();
        $this->config = $config['websocket'];
        $this->host = $this->config['host'];
        $this->port = $this->config['port'];
        $pid_file = $this->config['pid_file'];

        if (!file_exists($pid_file)) {
            touch($pid_file);
        }
        $this->pid = intval(file_get_contents($pid_file));

        $this->emitter = new Emitter();
        $this->emitter->useListenerProvider(new IMListenerProvider());
    }

    /**
     * @return bool
     */
    public function start()
    {
        $this->swooleWebSocketServer = new swoole_websocket_server($this->host, $this->port);
        $this->swooleWebSocketServer->set($this->config);

        $this->swooleWebSocketServer->on('open', [$this, 'onOpen']);
        $this->swooleWebSocketServer->on('message', [$this, 'onMessage']);
        $this->swooleWebSocketServer->on('request', [$this, 'onRequest']);
        $this->swooleWebSocketServer->on('close', [$this, 'onClose']);


        return $this->swooleWebSocketServer->start();
    }

    public function onOpen(swoole_websocket_server $swooleWebSocketServer, swoole_http_request $swooleHttpRequest)
    {
        $this->emitter->emit('im.open', $swooleWebSocketServer, $swooleHttpRequest);
    }

    public function onRequest(swoole_http_request $swooleHttpRequest, swoole_http_response $swooleHttpResponse)
    {
        $this->emitter->emit('im.request', $swooleHttpRequest, $swooleHttpResponse);
    }

    public function onMessage(swoole_websocket_server $swooleWebSocketServer, swoole_websocket_frame $swooleWebSocketFrame)
    {
        $this->emitter->emit('im.message', $swooleWebSocketServer, $swooleWebSocketFrame);
    }

    public function onClose(swoole_websocket_server $swooleWebSocketServer, $fd, $reactor_id)
    {
        $this->emitter->emit('im.close', $swooleWebSocketServer, $fd, $reactor_id);
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