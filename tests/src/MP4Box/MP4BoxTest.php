<?php

namespace MP4Box;

require_once dirname(__FILE__) . '/../../../src/MP4Box/MP4Box.php';

class MP4BoxTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var MP4Box
     */
    protected $object;

    /**
     * @covers MP4Box\MP4Box::load
     * @covers MP4Box\MP4Box::__construct
     */
    protected function setUp()
    {
        $logger = new \Monolog\Logger('tests');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $this->object = MP4Box::load($logger);
    }

    /**
     * @covers MP4Box\MP4Box::__construct
     */
    public function testConstruct()
    {
        $this->object = new MP4Box('whale');
    }

    /**
     * @covers MP4Box\MP4Box::open
     * @todo Implement testOpen().
     */
    public function testOpen()
    {
        $this->object->open(__DIR__ . '/../../files/Video.mp4');
    }

    /**
     * @covers MP4Box\MP4Box::process
     */
    public function testProcess()
    {
        $this->object->open(__DIR__ . '/../../files/Video.mp4')->process()->close();
    }

    /**
     * @covers MP4Box\MP4Box::process
     */
    public function testProcessOutput()
    {
        $out = __DIR__ . '/../../files/OutVideo.mp4';

        if (file_exists($out))
        {
            unlink($out);
        }

        $this->object->open(__DIR__ . '/../../files/Video.mp4')->process(array(), $out)->close();

        $this->assertTrue(file_exists($out));
        unlink($out);
    }

    /**
     * @covers MP4Box\MP4Box::open
     * @covers MP4Box\Exception\InvalidFileArgumentException
     * @expectedException MP4Box\Exception\InvalidFileArgumentException
     */
    public function testOpenFail()
    {
        $this->object->open(__DIR__ . '/../../files/Unknown');
    }

    /**
     * @covers MP4Box\MP4Box::process
     * @covers MP4Box\Exception\RuntimeException
     * @expectedException MP4Box\Exception\RuntimeException
     */
    public function testProcessFail()
    {
        $this->object->open(__DIR__ . '/../../files/WrongFile.mp4')->process();
    }

    /**
     * @covers MP4Box\MP4Box::process
     * @covers MP4Box\MP4Box::close
     * @covers MP4Box\Exception\LogicException
     * @expectedException MP4Box\Exception\LogicException
     */
    public function testProcessAfterClose()
    {
        $this->object->open(__DIR__ . '/../../files/Video.mp4')->close()->process();
    }

}
