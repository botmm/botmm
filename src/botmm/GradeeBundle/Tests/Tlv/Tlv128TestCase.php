<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t106;
use botmm\GradeeBundle\Tlv\tlv_t128;
use botmm\tools\Hex;
use botmm\tools\ServerTools;


class Tlv128TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_128()
    {
        $bytes = (new tlv_t128())->get_tlv_128(
            0x00,//$newins,
            0x01,//$readguid,
            0x00,//$guidchg,
            0x01000200,//$flag,
            "Sumsung GaGa",//$devicetype,
            Hex::HexStringToBin("01 02 03 04 05 06 07 08 09 0a 0b 0c 0d 0e 0f")//$guid
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
01 28
00 2a
00 00 00
01
00
01 00 02 00
00 0c
53 75 6d 73 75 6e 67 20 47 61 47 61
00 0f
01 02 03 04 05 06 07 08 09 0a 0b 0c 0d 0e 0f
00 00
HEX
            , $hex, "tlv_1 should parsed as expected");
    }


}