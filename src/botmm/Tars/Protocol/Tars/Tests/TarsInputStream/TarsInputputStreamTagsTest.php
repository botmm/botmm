<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsInputStream;


use botmm\Tars\Protocol\Tars\TarsInputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsInputStreamTagsTest extends TarsTestCase
{

    public function testReadTags()
    {
        $stream = TarsInputStream::fromHexString("1c2c3c4c");
        $data1  = $stream->readByte(1, true);
        $this->assertEquals(0, $data1);
        $data2 = $stream->readByte(2, true);
        $this->assertEquals(0, $data2);
        $data3 = $stream->readByte(3, true);
        $this->assertEquals(0, $data3);
        $data4 = $stream->readByte(4, true);
        $this->assertEquals(0, $data4);

    }

}