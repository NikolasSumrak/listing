<?php

namespace Sumrak\Listing;

class ListingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Listing
     */
    protected $fixture;

    public function testListing()
    {
        $data = [1,2,3,4,5,6];
        foreach ($data as $element) {
            $this->fixture->add($element);
        }

        foreach ($this->fixture as $key=>$value) {
            $this->assertEquals($value, $data[$key]);
        }
    }


    protected function setUp()
    {
        $this->fixture = new Listing();
    }

    protected function tearDown()
    {
        $this->fixture = NULL;
    }
}