<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t109;
use botmm\tools\Hex;


class Tlv109TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_109()
    {
        $bytes = (new tlv_t109())->get_tlv_109(
            Hex::HexStringToBin("01 02 03 04 05 06 07 08 09 0a 0b 0c 0d 0e 0f")
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
01 09 
00 0f 
01 02 03 04 05 06 07 08 09 0a 0b 0c 0d 0e 0f
HEX
            , $hex, "tlv_1 should parsed as expected");
    }


}