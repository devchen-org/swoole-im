<?php

namespace DevChen\SwooleIM\Services;

use DevChen\SwooleIM\Helpers\Redis;

class RoomService
{
    /**
     * sorted set
     *
     * @var string
     */
    protected $keyRoom = 'room:%d';

    /**
     * Hash
     *
     * @var string
     */
    protected $keyFd = 'fd:%d';

    /**
     * @var array
     */
    protected $config;

    protected $redis;

    public function __construct()
    {
        $this->redis = Redis::getInstance();
    }

    public function getFd($fd)
    {
        return $this->redis->hgetall(sprintf($this->keyFd, $fd));
    }

    public function setFd($fd, array $fields)
    {
        return $this->redis->hmset(sprintf($this->keyFd, $fd), $fields);
    }

    public function delFd($fd)
    {
        return $this->redis->del([sprintf($this->keyFd, $fd)]);
    }

    public function joinRoom($room_id, $fd)
    {
        return $this->redis->zadd(sprintf($this->keyRoom, $room_id), [
            $fd => time()
        ]);
    }

    public function quitRoom($room_id, $fd)
    {
        return $this->redis->zrem(sprintf($this->keyRoom, $room_id), $fd);
    }

    public function getRoom($room_id)
    {
        return $this->redis->zrange(sprintf($this->keyRoom, $room_id), 0, -1);
    }

}