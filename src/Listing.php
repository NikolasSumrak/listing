<?php

namespace Sumrak\Listing;


class Listing implements \IteratorAggregate
{
    protected $repository;

    public function __construct(ListingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function get($index)
    {
        return $this->repository->get($index);
    }

    public function add($element)
    {
        return $this->repository->add($element);
    }


    public function getIterator()
    {
        return new ListingIterator($this->repository);
    }
}