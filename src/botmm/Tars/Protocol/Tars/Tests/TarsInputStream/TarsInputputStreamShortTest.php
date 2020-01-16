<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsInputStream;


use botmm\Tars\Protocol\Tars\TarsInputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsInputStreamShortTest extends TarsTestCase
{

    /**
     * @return array
     */
    public function getShortData()
    {
        return [
            ['1c', 0],
            ['107f', 0x7f],
            ['1080', -128],
            ['110080', 0x80],
            ['11ff7f', -129],
            ['117fff', 0x7fff], //sign positive max
            ['118000', -0x8000],//sign negative max
            //['118000', 0x8000], //overflow for short
            //['117fff', -0x8001], //overflow for short
            ['118000', -0x8000], //overflow for short
            ['117fff', 0x7fff], //overflow for short

        ];
    }

    /**
     * @dataProvider getShortData
     * @param $expected
     * @param $data
     */
    public function testWriteShort($data, $expected)
    {
        $stream = TarsInputStream::fromHexString($data);
        $data   = $stream->readShort(1, true);
        $this->assertEquals($expected, $data);
    }

    public function getIntArrayData()
    {
        return [
            ['19000200010c', [1, 0]],
            ['19000300010c007f', [1, 0, 0x7f]],
            ['19000400010c007f010080', [1, 0, 0x7f, 0x80]],
            ['19000400010c007f017fff', [1, 0, 0x7f, 0x7fff]],
            ['19000400010c007f018000', [1, 0, 0x7f, -0x8000]],
            ['19000400010c007f018001', [1, 0, 0x7f, -0x7fff]],
        ];
    }

    /**
     * @dataProvider getIntArrayData
     * @param $expected
     * @param $byteArray
     */
    public function testWriteShortArray($data, $expected)
    {
        $stream = TarsInputStream::fromHexString($data);
        $data   = $stream->readShortArray(1, true);
        $this->assertEquals($expected, $data);
    }


}