<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsOutputStream;


use botmm\BufferBundle\Buffer\StreamOutputBuffer;
use botmm\Tars\Protocol\Tars\TarsOutputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;
use Ds\Map;
use Iterator;

class TarsOutputStreamMapTest extends TarsTestCase
{

    public function getMapData() {
        $map1 = new Map();
        $map1->put("abc", "def");

        $map2 = new Map();
        $map2->put(1,       "def");

        $map3 = new Map();
        $map3->put(1.1,       "def");

        return [
            //|-tag/map|count|key|value|
            ['18000106036162631603646566', $map1],
            ['18000100011603646566', $map2],
            ['180001043f8ccccd1603646566', $map3]
        ];
    }

    /**
     * @dataProvider getMapData
     */
    public function testWriteMap($expected, $data) {
        $stream = new TarsOutputStream();

        $stream->writeMap($data, 1);

        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());

    }

}
