<?php

namespace Sumrak\Listing;

use Sumrak\Listing\Storage\StorageInterface;

class ListingFactory
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * ListingFactory constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param int|null $runtimeLimit
     * @return Listing
     */
    public function create($runtimeLimit = null)
    {
        $listingRepository = new ListingRepository($this->storage, $runtimeLimit);
        $instance = new Listing($listingRepository, $runtimeLimit);
        return $instance;
    }

}