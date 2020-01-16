<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t141;
use botmm\tools\Hex;


class Tlv141TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_141()
    {
        $bytes = (new tlv_t141())->get_tlv_141(
            "",
            2,
            "wifi"
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
01 41 
00 0c
00 01 00 00 00 02 00 04 77 69 66 69
HEX
            , $hex, "tlv_1 should parsed as expected");
    }

    protected function assertBinEqualsHex($expected, $actual, $message = "")
    {
        $expected = Hex::BinToHexString(hex2bin(preg_replace('/\s/', '', $expected)));
        $actual   = Hex::BinToHexString(hex2bin(preg_replace('/\s/', '', $actual)));
        $this->assertEquals($expected, $actual, $message);
    }
}