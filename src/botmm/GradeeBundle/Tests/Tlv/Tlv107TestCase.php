<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t107;
use botmm\tools\Hex;


class Tlv107TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_107()
    {
        $bytes = (new tlv_t107())->get_tlv_107(
            Hex::HexStringToBin("00 00"),
            Hex::HexStringToBin("00"),
            Hex::HexStringToBin("00 00 00 00"),
            Hex::HexStringToBin("01")
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
01 07 
00 06
00 00
00 
00 00
01
HEX
            , $hex, "tlv_107 should parsed as expected");
    }


}