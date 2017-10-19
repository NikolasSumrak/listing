<?php

namespace Sumrak\Listing;


interface ListingRepositoryInterface
{
    public function add($element);
    public function get($index);
    public function count();
}