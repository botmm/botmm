<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsInputStream;


use botmm\Tars\Protocol\Tars\TarsInputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsInputStreamFloatAndDoubleTest extends TarsTestCase
{

    /**
     * @return array
     */
    public function getFloatData()
    {
        return [
            ['143f800000', 1],
            ['143f8ccccd', 1.1],
            ['14400ccccd', 2.2],
            ['1400000000', 0],
        ];
    }

    /**
     * @dataProvider getFloatData
     * @param $expected
     * @param $data
     */
    public function testReadFloat($data, $expected)
    {

        $stream = TarsInputStream::fromHexString($data);
        $data = $stream->readFloat(1, true);
        $this->assertEquals($expected, $data, "should almost equal", 0.0000001);
    }

    /**
     * @return array
     */
    public function getDoubleData()
    {
        return [
            ['153ff0000000000000', 1],
            ['153ff199999999999a', 1.1],
            ['15400199999999999a', 2.2],
            ['150000000000000000', 0],
        ];
    }

    /**
     * @dataProvider getDoubleData
     * @param $expected
     * @param $data
     */
    public function testReadDouble($data, $expected)
    {
        $stream = TarsInputStream::fromHexString($data);
        $data = $stream->readDouble(1, true);
        $this->assertEquals($expected, $data);
    }

}