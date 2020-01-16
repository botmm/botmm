<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t100;
use botmm\GradeeBundle\Tlv\tlv_t106;
use botmm\GradeeBundle\Tlv\tlv_t116;
use botmm\tools\Hex;
use botmm\tools\ServerTools;

class Tlv100TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_100()
    {
        //$appid, $wxappid, $client_ver, $getsig
        $bytes = (new tlv_t100())->get_tlv_100(
            0x00000010,
            0,
            0,
            0x000E10E0
            );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
01 00
00 16
00 01
00 00 00 05
00 00 00 10
00 00 00 00
00 00 00 00
00 0e 10 e0
HEX
            , $hex, "tlv_1 should parsed as expected");
    }


}