<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsInputStream;


use botmm\BufferBundle\Buffer\StreamOutputBuffer;
use botmm\Tars\Protocol\Tars\TarsInputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsInputStream\TarsStructSample\TarsStructSample001;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;
use Ds\Map;
use Iterator;

class TarsInputStreamStructTest extends TarsTestCase
{

    public function getStructData() {
        $struct1 = new TarsStructSample001();
        $struct1->data1 = 0xff;
        $struct1->data2 = 0x7fffffff;

        return [
            //1a
            //11 short 00ff
            //22 int   7fffffff
            //0b
            ['1a1100ff227fffffff0b', $struct1],
        ];
    }

    /**
     * @dataProvider getStructData
     */
    public function testWriteStruct($data, $expected) {
        $stream = TarsInputStream::fromHexString($data);

        $struct = new TarsStructSample001();
        $stream->readTarsStruct($struct, 1, true);

        $this->assertEquals($expected->data1, $struct->data1);
        $this->assertEquals($expected->data2, $struct->data2);

    }

}
