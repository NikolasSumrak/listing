<?php

namespace Sumrak\Listing\Storage;


class RedisStorage implements StorageInterface
{
    protected $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    public function writePart($repositoryId, $part, $elements)
    {
        //$key = $this->redis->hVals();
    }

    public function readPart($repositoryId, $part)
    {

    }

    protected function getPartKey($repositoryId, $part)
    {
        return $repositoryId . ':' . $part;
    }

    public function flush($repositoryId)
    {
        $key = $this->getPartKey($repositoryId, '*');
        $this->redis->delete($key);
    }
}