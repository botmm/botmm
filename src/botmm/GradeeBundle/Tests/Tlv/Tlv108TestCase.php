<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t106;
use botmm\GradeeBundle\Tlv\tlv_t108;
use botmm\GradeeBundle\Tlv\tlv_t116;
use botmm\tools\Hex;
use botmm\tools\ServerTools;


class Tlv108TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_108()
    {
        $bytes = (new tlv_t108())->get_tlv_108(
            Hex::HexStringToBin("93 33 4E AD B8 08 D3 42 82 55 B7 EF 28 E7 E8 F5")
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
01 08
00 10
93 33 4e ad b8 08 d3 42 82 55 b7 ef 28 e7 e8 f5
HEX
            , $hex, "tlv_1 should parsed as expected");
    }


}