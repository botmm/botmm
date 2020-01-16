<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsOutputStream;


use botmm\Tars\Protocol\Tars\TarsOutputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsOutputStreamTagsTest extends TarsTestCase
{

    public function testWriteTags()
    {
        $stream = new TarsOutputStream();
        $stream->writeByte(0, 1);
        $stream->writeByte(0, 2);
        $stream->writeByte(0, 3);
        $stream->writeByte(0, 4);

        $this->assertEquals(hex2bin('1c2c3c4c'), $stream->getByteBuffer());
    }

}