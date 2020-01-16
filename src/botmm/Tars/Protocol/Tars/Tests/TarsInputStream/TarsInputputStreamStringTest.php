<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsInputStream;


use botmm\Tars\Protocol\Tars\TarsInputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsInputStreamStringTest extends TarsTestCase
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
            ['160412345678', "12345678"],
            ["1700000100{$string4}", $string4]
        ];
    }

    /**
     * @dataProvider getData
     * @param $expected
     * @param $data
     */
    public function testReadHexString($data, $expected)
    {
        $stream = TarsInputStream::fromHexString($data);
        $data   = $stream->readHexString(1, true);
        $this->assertEquals($expected, $data);
    }

    /**
     * @dataProvider getData
     * @param $expected
     * @param $data
     */
    public function testReadByteString($data, $expected)
    {
        $stream = TarsInputStream::fromHexString($data);
        $data   = $stream->readByteString(1, true);
        $this->assertEquals(hex2bin($expected), $data);
    }

    public function getEncodeString()
    {
        return [
            ['1606e4b8ade69687',"中文"], //utf8 encode string
            ['1602c2a5', "¥"]
        ];
    }

    /**
     * @dataProvider getEncodeString
     * @param $expected
     * @param $data
     */
    public function testReadEncodeString($data, $expected)
    {
        $stream = TarsInputStream::fromHexString($data);
        $data   = $stream->readString(1, true);
        $this->assertEquals($expected, $data);
    }

    public function getByteStringArrayData()
    {
        return [
            ['19000206036162630603646566', ["abc", "def"]],
            ['1900010606e4b8ade69687', ["中文"]], //utf-8
            ['1900010604d6d0cec4', ["中文"]], //gbk

        ];
    }

    /**
     * @dataProvider getByteStringArrayData
     * @param $expected
     * @param $byteArray
     */
    public function testReadByteStringArray($data, $expected)
    {
        $stream = TarsInputStream::fromHexString($data);
        $data   = $stream->readStringArray(1, true);
        $this->assertEquals($expected, $data);
    }

    public function getStringArrayData()
    {
        return [
            ['19000206036162630603646566', ["abc", "def"]],
            ['1900010606e4b8ade69687', ["中文"]],

        ];
    }

    /**
     * @dataProvider getStringArrayData
     * @param $expected
     * @param $byteArray
     */
    public function testReadStringArray($data, $expected)
    {
        $stream = TarsInputStream::fromHexString($data);
        $data   = $stream->readStringArray(1, true);
        $this->assertEquals($expected, $data);
    }

}