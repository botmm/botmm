<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsOutputStream;


use botmm\Tars\Protocol\Tars\TarsOutputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsOutputStreamByteTest extends TarsTestCase
{

    /**
     * @return array
     */
    public function getByteData()
    {
        return [
            ['1c',      0],
            ['1001',    1],
            ['10ff',    -1],
            ['107f',    0x7f],
            ['1080',    -128],
            ['1080',    0x80],//overflow for sign int (1 byte) and we don't need to check it, because just 8bit available
            ['107f',    -129],//overflow for sign int (1 byte) and we don't need to check it, because just 8bit available
        ];
    }

    /**
     * @dataProvider getByteData
     * @param $expected
     * @param $data
     */
    public function testWriteByte($expected, $data)
    {
        $stream = new TarsOutputStream();
        $stream->writeByte($data, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }

    /**
     * @return array
     */
    public function getBooleanData() {
        return [
            ['1c', false],
            ['1001', true]
        ];
    }

    /**
     * @dataProvider getBooleanData
     * @param $expected
     * @param $boolean
     */
    public function testWriteBoolean($expected, $boolean)
    {
        $stream = new TarsOutputStream();
        $stream->writeBoolean($boolean, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }

    /**
     * @return array
     */
    public function getBooleanArrayData()
    {
        return [
            ['1900030c00010c',      [false, true, false]],
        ];
    }

    /**
     * @dataProvider getBooleanArrayData
     * @param $expected
     * @param $booleanArray
     */
    public function testWriteBooleanArray($expected, $booleanArray)
    {
        $stream = new TarsOutputStream();
        $stream->writeBooleanArray($booleanArray, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }

    public function getByteArrayData()
    {
        return [
            ['1d00000301007f', [1, 0, 0x7f]],
        ];
    }

    /**
     * @dataProvider getByteArrayData
     * @param $expected
     * @param $byteArray
     */
    public function testWriteByteArray($expected, $byteArray)
    {
        $stream = new TarsOutputStream();
        $stream->writeByteArray($byteArray, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }

    public function testWriteIntException()
    {
        $this->expectException('InvalidArgumentException');
        $stream = new TarsOutputStream();
        $stream->writeInt(0x100000000, 1);
    }


}