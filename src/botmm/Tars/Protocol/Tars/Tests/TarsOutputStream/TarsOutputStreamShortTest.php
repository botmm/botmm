<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsOutputStream;


use botmm\Tars\Protocol\Tars\TarsOutputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsOutputStreamShortTest extends TarsTestCase
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
            ['118000', 0x8000], //overflow for short
            ['117fff', -0x8001], //overflow for short

        ];
    }

    /**
     * @dataProvider getShortData
     * @param $expected
     * @param $data
     */
    public function testWriteShort($expected, $data)
    {
        $stream = new TarsOutputStream();
        $stream->writeShort($data, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }

    public function getIntArrayData()
    {
        return [
            ['19000200010c', [1, 0]],
            ['19000300010c007f', [1, 0, 0x7f]],
            ['19000400010c007f010080', [1, 0, 0x7f, 0x80]],
            ['19000400010c007f017fff', [1, 0, 0x7f, 0x7fff]],
            ['19000400010c007f018000', [1, 0, 0x7f, 0x8000]],
        ];
    }

    /**
     * @dataProvider getIntArrayData
     * @param $expected
     * @param $byteArray
     */
    public function testWriteShortArray($expected, $byteArray)
    {
        $stream = new TarsOutputStream();
        $stream->writeShortArray($byteArray, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }


}