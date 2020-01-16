<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t106;
use botmm\GradeeBundle\Tlv\tlv_t145;
use botmm\tools\Hex;
use botmm\tools\ServerTools;


class Tlv145TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_145()
    {
        $bytes = (new tlv_t145())->get_tlv_145(
           Hex::HexStringToBin("01 02 03 04 05 06 07 08 09 0a 0b 0c 0d 0e 0f")
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
01 45
00 0f
01 02 03 04 05 06 07 08 09 0a 0b 0c 0d 0e 0f
HEX
            , $hex, "tlv_1 should parsed as expected");
    }


}