<?php

use Sly\UrlShortenerBundle\Manager\Manager;

/**
 * Manager tests.
 * 
 * @author Cédric Dugat <ph3@slynett.com>
 */
class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test Manager.
     */
    public function testManager()
    {
        $manager  = $this->getMock('Sly\UrlShortenerBundle\Manager\Manager', array(), array(), '', false);

        $this->markTestIncomplete('First Manager test has to be completed');
    }

    /**
     * Get test configuration.
     * 
     * @return array
     */
    protected function getTestConfig()
    {
        return array(
            'provider' => 'internal',
            'domain'   => 'te.st',
            'entities' => array(
                'Test\Entity\Content' => array(
                    'provider' => 'googl',
                ),
            ),
        );
    }
}
