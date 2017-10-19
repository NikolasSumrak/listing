<?php

namespace Sumrak\Listing\Storage;


interface StorageInterface
{
    public function writePart($repositoryId, $part, $elements);
    public function readPart($repositoryId, $part);
    public function flush($repositoryId);
}