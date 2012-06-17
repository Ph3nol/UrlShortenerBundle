<?php

namespace Sly\UrlShortenerBundle\Tests\Config;

use Sly\UrlShortenerBundle\Config\Config;

/**
 * Config tests.
 * 
 * @author Cédric Dugat <ph3@slynett.com>
 */
class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test Manager.
     */
    public function testConfig()
    {
        $config = new Config($this->getTestConfig());

        $this->assertInstanceOf('Sly\UrlShortenerBundle\Config\ConfigInterface', $config);

        $this->assertObjectHasAttribute('config', $config);
        $this->assertObjectHasAttribute('entities', $config);
    }

    /**
     * Test config getter.
     */
    public function testConfigGetter()
    {
        $config       = new Config($this->getTestConfig());
        $configConfig = $config->getConfig();

        $this->assertTrue(is_array($configConfig));
        $this->assertArrayHasKey('provider', $configConfig);
        $this->assertArrayHasKey('domain', $configConfig);
    }

    /**
     * Test entities getter.
     */
    public function testEntitiesGetter()
    {
        $config         = new Config($this->getTestConfig());
        $configEntities = $config->getEntities();

        $this->assertTrue(is_object($configEntities));
        $this->assertInstanceOf('Sly\UrlShortenerBundle\Model\EntityCollection', $configEntities);
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
