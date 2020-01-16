<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsOutputStream;


use botmm\Tars\Protocol\Tars\TarsOutputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsOutputStreamStringTest extends TarsTestCase
{

    /**
     * @return array
     */
    public function getData()
    {
        $string4 = "000102030405060708090a0b0c0d0e0f" .
                   "010102030405060708090a0b0c0d0e0f" .
                   "020102030405060708090a0b0c0d0e0f" .
                   "030102030405060708090a0b0c0d0e0f" .
                   "040102030405060708090a0b0c0d0e0f" .
                   "050102030405060708090a0b0c0d0e0f" .
                   "060102030405060708090a0b0c0d0e0f" .
                   "070102030405060708090a0b0c0d0e0f" .
                   "080102030405060708090a0b0c0d0e0f" .
                   "090102030405060708090a0b0c0d0e0f" .
                   "0a0102030405060708090a0b0c0d0e0f" .
                   "0b0102030405060708090a0b0c0d0e0f" .
                   "0c0102030405060708090a0b0c0d0e0f" .
                   "0d0102030405060708090a0b0c0d0e0f" .
                   "0e0102030405060708090a0b0c0d0e0f" .
                   "0f0102030405060708090a0b0c0d0e0f";
        return [
            ['1604' . '12345678', "12345678"],
            ['1700000100' . $string4, $string4]
        ];
    }

    /**
     * @dataProvider getData
     * @param $expected
     * @param $data
     */
    public function testWriteHexString($expected, $data)
    {
        $stream = new TarsOutputStream();
        $stream->writeHexString($data, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());

        $stream = new TarsOutputStream();
        $stream->writeByteString(hex2bin($data), 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }

    public function getEncodeString()
    {
        return [
            ['1606e4b8ade69687', "中文"], //utf8 encode string
            ['1602c2a5', "¥"]
        ];
    }

    /**
     * @dataProvider getEncodeString
     * @param $expected
     * @param $data
     */
    public function testWriteEncodeString($expected, $data)
    {
        $stream = new TarsOutputStream();
        $stream->writeString($data, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }

    public function getByteStringArrayData()
    {
        return [
            ['19000206036162630603646566', ["abc", "def"]],
            ['1900010606e4b8ade69687', ["中文"]],
            ['1900010604d6d0cec4', [mb_convert_encoding("中文", "GBK")]],

        ];
    }

    /**
     * @dataProvider getByteStringArrayData
     * @param $expected
     * @param $byteArray
     */
    public function testWriteByteStringArray($expected, $byteArray)
    {
        $stream = new TarsOutputStream();
        $stream->writeByteStringArray($byteArray, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }

    public function getStringArrayData()
    {
        return [
            ['19000206036162630603646566', ["abc", "def"]],
            ['1900010606e4b8ade69687', ["中文"]],
            ['1900010606e4b8ade69687', [mb_convert_encoding("中文", "GBK")]],

        ];
    }

    /**
     * @dataProvider getStringArrayData
     * @param $expected
     * @param $byteArray
     */
    public function testWriteStringArray($expected, $byteArray)
    {
        $stream = new TarsOutputStream();
        //can use mb_detect_order
        $stream->writeStringArray($byteArray, 1, "GBK");
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }

}