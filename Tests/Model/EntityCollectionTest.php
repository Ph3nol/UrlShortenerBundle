<?php

namespace Sly\UrlShortenerBundle\Tests\Model;

use Sly\UrlShortenerBundle\Model\EntityCollection;

/**
 * EntityCollection tests.
 * 
 * @author Cédric Dugat <ph3@slynett.com>
 */
class EntityCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test collection.
     */
    public function testCollection()
    {
        $collection = new EntityCollection();

        $this->assertInstanceOf('ArrayIterator', $collection->getIterator());
        $this->assertInstanceOf('ArrayIterator', $collection->getEntities());

        $collection->set('Test\Test', array(
            'provider' => 'internal',
            'domain'   => 'te.st',
        ));

        $this->assertTrue($collection->has('Test\Test'));
        $this->assertFalse($collection->has('Test\WrongTest'));
        $this->assertTrue(is_array($collection->get('Test\Test')));
        $this->assertArrayHasKey('provider', $collection->get('Test\Test'));
        $this->assertArrayHasKey('domain', $collection->get('Test\Test'));
    }
}
