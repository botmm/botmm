<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsInputStream;


use botmm\Tars\Protocol\Tars\TarsInputStream;
use botmm\Tars\Protocol\Tars\Tests\TarsTestCase;

class TarsInputStreamLongTest extends TarsTestCase
{

    /**
     * @return array
     */
    public function getLongData()
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
            ['130000000080000000', 0x80000000],
            ['13ffffffff7fffffff', -0x80000001],
            ['137fffffffffffffff', 0x7fffffffffffffff],
            //['138000000000000000', 0x8000000000000000], //overflow
        ];
    }

    /**
     * @dataProvider getLongData
     * @param $expected
     * @param $data
     */
    public function testWriteLong($data, $expected)
    {
        $stream = TarsInputStream::fromHexString($data);
        $data = $stream->readLong(1, true);
        $this->assertEquals(dechex($expected), dechex($data));
    }

    public function getIntArrayData()
    {
        return [
            ['19000200010c', [1, 0]],
            ['19000300010c007f', [1, 0, 0x7f]],
            ['19000400010c007f010080', [1, 0, 0x7f, 0x80]],
            ['19000500010c007f010080027fffffff', [1, 0, 0x7f, 0x80, 0x7fffffff]],
            ['19000600010c007f010080027fffffff030000000080000000', [1, 0, 0x7f, 0x80, 0x7fffffff, 0x80000000]],
            ['19000700010c007f010080027fffffff030000000080000000037fffffffffffffff', [1, 0, 0x7f, 0x80, 0x7fffffff, 0x80000000, 0x7fffffffffffffff]],
        ];
    }

    /**
     * @dataProvider getIntArrayData
     * @param $expected
     * @param $byteArray
     */
    public function testWriteLongArray($data, $expected)
    {
        $stream = TarsInputStream::fromHexString($data);
        $data = $stream->readLongArray(1, true);
        $this->assertEquals($expected, $data);
    }

}