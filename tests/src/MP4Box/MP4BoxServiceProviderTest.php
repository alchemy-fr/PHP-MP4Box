<?php

namespace MP4Box;

use Silex\Application;
use Monolog\Logger;
use Monolog\Handler\NullHandler;

require_once dirname(__FILE__) . '/../../../src/MP4Box/MP4Box.php';

class MP4BoxServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    public function getApplication()
    {
        return new Application();
    }

    public function testInit()
    {
        $app = $this->getApplication();
        $app->register(new MP4BoxServiceProvider());

        $this->assertInstanceOf('\\MP4Box\\MP4Box', $app['mp4box']);
    }

    /**
     * @expectedException MP4Box\Exception\BinaryNotFoundException
     */
    public function testInitFailOnBinary()
    {
        $app = $this->getApplication();
        $app->register(new MP4BoxServiceProvider(), array('mp4box.binary' => 'no/binary/here'));

        $app['mp4box'];
    }

    public function testInitCustomLogger()
    {
        $logger = new Logger('test');
        $logger->pushHandler(new NullHandler());

        $app = $this->getApplication();
        $app->register(new MP4BoxServiceProvider(), array('mp4box.logger' => $logger));

        $this->assertInstanceOf('\\MP4Box\\MP4Box', $app['mp4box']);
    }
}
