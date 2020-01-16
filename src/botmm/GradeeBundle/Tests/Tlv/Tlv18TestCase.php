<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t18;
use botmm\tools\Hex;


class Tlv18TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv()
    {
        $bytes = (new tlv_t18())->get_tlv_18(
            0x00000010,
            0,
            $this->uin,
            0
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
00 18 
00 16 
00 01 
00 00 06 00 
00 00 00 10 
00 00 00 00 
00 2b c0 65 
00 00 
00 00
HEX
            , $hex, "tlv_1 should parsed as expected {$hex}");
    }


}