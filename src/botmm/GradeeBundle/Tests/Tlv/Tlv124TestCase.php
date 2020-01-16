<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t124;
use botmm\tools\Hex;


class Tlv124TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_124()
    {
        $bytes = (new tlv_t124())->get_tlv_124(
            "android",
            "4.4.4",
            2,
            "",
            "",
            "wifi"
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
01 24
00 1c

00 07
61 6e 64 72 6f 69 64

00 05
34 2e 34 2e 34 

00 02

00 00

00 00

00 04
77 69 66 69
HEX
            , $hex, "tlv_1 should parsed as expected");
    }


}