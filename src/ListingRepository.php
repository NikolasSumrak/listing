<?php

namespace Sumrak\Listing;

use Sumrak\Listing\Storage\StorageInterface;

class ListingRepository implements ListingRepositoryInterface
{
    const DEFAULT_LIMIT = 100;
    const REPOSITORY_ID_PREFIX = 'listing_repository_';

    protected $repositoryId;
    protected $runtimeLimit;
    protected $storage;
    protected $nextIndex = 0;
    protected $runtimeElements = [];
    protected $currentPart = 1;
    protected $countDeletedElements = 0;

    public function __construct(StorageInterface $storage, $runtimeLimit = null)
    {
        $this->repositoryId = uniqid(static::REPOSITORY_ID_PREFIX, true);
        is_null($runtimeLimit) && $runtimeLimit = static::DEFAULT_LIMIT;
        $this->storage = $storage;
        $this->runtimeLimit = $runtimeLimit;
    }

    public function count()
    {
        return $this->nextIndex - $this->countDeletedElements;
    }

    public function add($element)
    {
        $index = $this->nextIndex++;
        $part = $this->getPartByIndex($index);
        if ( $part != $this->currentPart ) {
            $this->writeToStorage();
            $this->runtimeElements = [];
            $this->currentPart = $part;
        }
        $this->runtimeElements[$index] = $element;
    }

    public function get($index)
    {
        $part = $this->getPartByIndex($index);
        if ( $part != $this->currentPart ) {
            $this->writeToStorage();
            $this->readFromStorage($part);
            $this->currentPart = $part;
        }

        if ( !isset($this->runtimeElements[$index]) ) {
            throw new ElementNotFoundException('Element with index ' . $index . ' not found');
        }

        return $this->runtimeElements[$index];
    }

    public function __destruct()
    {
        $this->flushStorage();
    }


    protected function getPartByIndex($index)
    {
        $part = $index / $this->runtimeLimit;
        $part = floor($part) + 1;
        return $part;
    }

    protected function writeToStorage()
    {
        $this->storage->writePart($this->repositoryId, $this->currentPart, $this->runtimeElements);
    }

    protected function readFromStorage($part)
    {
        $this->runtimeElements = $this->storage->readPart($this->repositoryId, $part);
    }

    protected function flushStorage()
    {
        $this->storage->flush($this->repositoryId);
    }

}