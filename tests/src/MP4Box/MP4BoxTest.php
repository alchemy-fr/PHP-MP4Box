<?php

namespace MP4Box;

use Monolog\Logger;
use Monolog\Handler\NullHandler;

require_once dirname(__FILE__) . '/../../../src/MP4Box/MP4Box.php';

class MP4BoxTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MP4Box
     */
    protected $object;

    protected function setUp()
    {
        $this->object = MP4Box::create();
    }

    public function testProcess()
    {
        $this->object->process(__DIR__ . '/../../files/Video.mp4');
    }

    public function testProcessOutput()
    {
        $out = __DIR__ . '/../../files/OutVideo.mp4';

        if (file_exists($out)) {
            unlink($out);
        }

        $this->object->process(__DIR__ . '/../../files/Video.mp4', $out);
        $this->assertTrue(file_exists($out));
        unlink($out);
    }

    /**
     * @expectedException MP4Box\Exception\InvalidFileArgumentException
     */
    public function testOpenFail()
    {
        $this->object->process(__DIR__ . '/../../files/Unknown');
    }

    /**
     * @expectedException MP4Box\Exception\RuntimeException
     */
    public function testProcessFail()
    {
        $this->object->process(__DIR__ . '/../../files/WrongFile.mp4');
    }
}
