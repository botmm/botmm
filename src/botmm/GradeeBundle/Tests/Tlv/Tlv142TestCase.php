<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t142;
use botmm\tools\Hex;


class Tlv142TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_142()
    {
        $bytes = (new tlv_t142())->get_tlv_142(
            "com.tencent.qqlite"
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
01 42 
00 16 
00 00 
00 12 
63 6f 6d 2e 74 65 6e 63 65 6e 74 2e 71 71 6c 69 74 65
HEX
            , $hex, "tlv_1 should parsed as expected");
    }


}