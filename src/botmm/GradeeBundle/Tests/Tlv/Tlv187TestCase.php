<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t106;
use botmm\GradeeBundle\Tlv\tlv_t116;
use botmm\tools\Hex;
use botmm\tools\ServerTools;


class Tlv116TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_116()
    {
        $bytes = (new tlv_t116())->get_tlv_116(
            Hex::HexStringToBin("00 00 7f 7c"),
            Hex::HexStringToBin("00 01 04 00"),
            null
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
01 16
00 0a
00
00 00 7f 7c
00 01 04 00
00
HEX
            , $hex, "tlv_1 should parsed as expected");
    }


}