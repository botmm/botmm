<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsOutputStream;


use botmm\BufferBundle\Buffer\StreamOutputBuffer;
use botmm\Tars\Protocol\Tars\TarsOutputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsOutputStream\TarsStructSample\TarsStructSample001;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;
use Ds\Map;
use Iterator;

class TarsOutputStreamStructTest extends TarsTestCase
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
    public function testWriteStruct($expected, $data) {
        $stream = new TarsOutputStream();

        $stream->writeTarsStruct($data, 1);

        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());

    }

}
