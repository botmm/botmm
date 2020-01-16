<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsInputStream;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\Tars\Protocol\Tars\TarsInputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsInputStreamByteTest extends TarsTestCase
{

    /**
     * @return array
     */
    public function getByteData()
    {
        return [
            ['1c', 0 & 0xff],
            ['1001', 1 & 0xff],
            ['10ff', -1 & 0xff],
            ['107f', 0x7f & 0xff],
            ['1080', -128 & 0xff],
            ['1080', 0x80 & 0xff],
            //overflow for sign int (1 byte) and we don't need to check it, because just 8bit available
            ['107f', -129 & 0xff],
            //overflow for sign int (1 byte) and we don't need to check it, because just 8bit available
        ];
    }

    /**
     * @dataProvider getByteData
     * @param $expected
     * @param $data
     */
    public function testReadByte($source, $expected)
    {
        $stream = TarsInputStream::fromHexString($source);
        $data   = $stream->readByte(1, true);
        $this->assertEquals($expected, $data);
    }

    /**
     * @return array
     */
    public function getBooleanData()
    {
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
    public function testReadBoolean($source, $expected)
    {
        $stream = TarsInputStream::fromHexString($source);
        $data = $stream->readBoolean(1, true);
        $this->assertEquals($expected, $data);
    }

    /**
     * @return array
     */
    public function getBooleanArrayData()
    {
        return [
            ['1900030c00010c', [false, true, false]],
        ];
    }

    /**
     * @dataProvider getBooleanArrayData
     * @param $expected
     * @param $booleanArray
     */
    public function testReadBooleanArray($source, $expected)
    {
        $stream = TarsInputStream::fromHexString($source);
        $data = $stream->readBooleanArray(1, true);
        $this->assertEquals($expected, $data);
    }

    public function getByteArrayData()
    {
        return [
            ['1d00000301007f2d00000301007f', [1, 0, 0x7f]],
        ];
    }

    /**
     * @dataProvider getByteArrayData()
     * @param $expected
     * @param $byteArray
     */
    public function testReadByteArray($source, $expected)
    {
        $stream = TarsInputStream::fromHexString($source);
        $data = $stream->readByteArray(1, true);
        $this->assertEquals($expected, $data);

        $data2 = $stream->readByteArray(2, true);
        $this->assertEquals($expected, $data2);
    }

}