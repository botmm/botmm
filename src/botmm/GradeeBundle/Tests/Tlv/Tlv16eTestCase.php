<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t16e;
use botmm\tools\Hex;


class Tlv16eTestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_16e()
    {
        $bytes = (new tlv_t16e())->get_tlv_16e(
            "HUAWEI U9508"
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
01 6e
00 0c
48 55 41 57 45 49 20 55 39 35 30 38
HEX
            , $hex, "tlv_1 should parsed as expected");
    }


}