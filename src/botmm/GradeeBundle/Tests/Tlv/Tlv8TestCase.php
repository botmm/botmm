<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t8;
use botmm\tools\Hex;


class Tlv8TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_8()
    {
        $bytes = (new tlv_t8())->get_tlv_8(
            0,
            Hex::HexStringToBin("00 00 08 04"),
            0
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