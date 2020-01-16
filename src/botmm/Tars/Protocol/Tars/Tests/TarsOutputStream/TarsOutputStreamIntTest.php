<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsOutputStream;


use botmm\Tars\Protocol\Tars\TarsOutputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsOutputStreamIntTest extends TarsTestCase
{

    /**
     * @return array
     */
    public function getIntData()
    {
        return [
            ['1c', 0],
            ['107f', 0x7f],
            ['1080', -128],
            ['110080', 0x80],
            ['11ff7f', -129],
            ['117fff', 0x7fff],
            ['118000', -0x8000],
            ['1200008000', 0x8000],
            ['12ffff7fff', -0x8001],
            ['127fffffff', 0x7fffffff],  //positive max
            ['1280000000', -0x80000000], //negative max


        ];
    }

    /**
     * @dataProvider getIntData
     * @param $expected
     * @param $data
     */
    public function testWriteInt($expected, $data)
    {
        $stream = new TarsOutputStream();
        $stream->writeInt($data, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }

    public function getIntArrayData()
    {
        return [
            ['19000200010c', [1, 0]],
            ['19000300010c007f', [1, 0, 0x7f]],
            ['19000400010c007f010080', [1, 0, 0x7f, 0x80]],
            ['19000500010c007f010080027fffffff', [1, 0, 0x7f, 0x80, 0x7fffffff]],
            ['19000600010c007f010080027fffffff0280000000', [1, 0, 0x7f, 0x80, 0x7fffffff, 0x80000000]],
        ];
    }

    /**
     * @dataProvider getIntArrayData
     * @param $expected
     * @param $byteArray
     */
    public function testWriteIntArray($expected, $byteArray)
    {
        $stream = new TarsOutputStream();
        $stream->writeIntArray($byteArray, 1);
        $this->assertEquals(hex2bin($expected), $stream->getByteBuffer());
    }


}