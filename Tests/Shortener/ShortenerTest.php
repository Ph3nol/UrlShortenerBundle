<?php

use Sly\UrlShortenerBundle\Shortener\Shortener;

/**
 * Shortener tests.
 */
class ShortenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test hash from bit.
     */
    public function testHashFromBit()
    {
        $this->assertNotNull(Shortener::getHashFromBit());

        $this->assertEquals(Shortener::getHashFromBit(), '1');
        $this->assertEquals(Shortener::getHashFromBit(1), '1');
        $this->assertEquals(Shortener::getHashFromBit(10), 'a');
        $this->assertEquals(Shortener::getHashFromBit(100), '1C');
        $this->assertEquals(Shortener::getHashFromBit(12345), '3d7');
    }
}
