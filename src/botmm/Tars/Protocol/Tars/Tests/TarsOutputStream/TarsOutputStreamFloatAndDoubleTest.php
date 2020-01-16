<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsOutputStream;


use botmm\Tars\Protocol\Tars\TarsOutputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsOutputStreamFloatAndDoubleTest extends TarsTestCase
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
    public function testWriteFloat($expected, $data)
    {
        $stream = new TarsOutputStream();
        $stream->writeFloat($data, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
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
    public function testWriteDouble($expected, $data)
    {
        $stream = new TarsOutputStream();
        $stream->writeDouble($data, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }

}