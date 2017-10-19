<?php

namespace Sumrak\Listing;


class ListingIterator implements \Iterator, \Countable
{
    protected $position = 0;
    protected $repository;

    public function __construct(ListingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function current()
    {
        return $this->repository->get($this->position);
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        if($this->position > $this->repository->getCount()) {
            return false;
        }
        try {
            $element = $this->repository->get($this->position);
        } catch (ElementNotFoundException $elementNotFoundException) {
            ++$this->position;
            return $this->valid();
        }
        return true;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function count()
    {
        return $this->repository->getCount();
    }
}