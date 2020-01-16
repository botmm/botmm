<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsInputStream;


use botmm\BufferBundle\Buffer\StreamOutputBuffer;
use botmm\Tars\Protocol\Tars\TarsInputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;
use Ds\Map;
use Iterator;

class TarsInputStreamMapTest extends TarsTestCase
{

    public function getMapData()
    {
        $map1 = new Map();
        $map1->put("abc", "def");

        $map2 = new Map();
        $map2->put(1, "def");

        $map3 = new Map();
        $map3->put(1.1, "def");

        return [
            //|-tag/map|count|key|value|
            [["string" => "string"], '18000106036162631603646566', $map1],
            [["int" => "string"], '18000100011603646566', $map2],
            [["float" => "string"], '180001043f8ccccd1603646566', $map3]
        ];
    }

    /**
     * @dataProvider getMapData
     */
    public function testReadTypeMap($mt, $data, $expected)
    {
        $stream = TarsInputStream::fromHexString($data);
        $data   = $stream->readTypeMap($mt, 1, true);
        $this->assertEquals($expected, $data);

    }

    /**
     * @dataProvider getMapData
     */
    public function testReadMap($mt, $data, $expected)
    {
        $stream = TarsInputStream::fromHexString($data);
        $data   = $stream->readMap(1, true);
        $this->assertEquals($expected, $data);

    }

}
