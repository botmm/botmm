<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t106;
use botmm\GradeeBundle\Tlv\tlv_t154;
use botmm\tools\Hex;
use botmm\tools\ServerTools;


class Tlv154TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_154()
    {
        $bytes = (new tlv_t154())->get_tlv_154(
            2
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
01 54
00 04 
00 00 00 02
HEX
            , $hex, "tlv_1 should parsed as expected");
    }


}