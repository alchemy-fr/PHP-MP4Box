<?php

namespace MP4Box\Functional;

use MP4Box\MP4Box;
use \PHPUnit\Framework\TestCase;

class MP4BoxTest extends TestCase
{
    public function testProcess()
    {
        $mp4box = MP4Box::create();
        $mp4box->process(__DIR__ . '/../../files/Video.mp4');
    }

    public function testProcessWithCustomOutput()
    {
        $out = __DIR__ . '/../../files/OutVideo.mp4';

        if (file_exists($out)) {
            unlink($out);
        }

        $mp4box = MP4Box::create();
        $mp4box->process(__DIR__ . '/../../files/Video.mp4', $out);
        $this->assertTrue(file_exists($out));
        unlink($out);
    }

    /**
     * @expectedException MP4Box\Exception\RuntimeException
     */
    public function testProcessFail()
    {
        $mp4box = MP4Box::create();
        $mp4box->process(__DIR__ . '/../../files/WrongFile.mp4');
    }
}
