<?php


namespace botmm\ClientBundle\Tests\Client;


use botmm\ClientBundle\Client\Login;
use botmm\tools\Hex;
use PHPUnit_Framework_TestCase;

class LoginTestCase extends PHPUnit_Framework_TestCase
{


    /**
     * 00 18 //tlv18
     * 00 16 //tlv长度22 如果太长不是tlv包
     * 00 01 //_ping_version=1
     * 00 00 06 00 //_sso_version=1536
     * 00 00 00 10 //_appid
     * 00 00 00 00 //_app_client_version
     * 18 B4 A1 BC [QQ号码：414491068]
     * 00 00 //0
     * 00 00 //0
     */
    public function testTlv_18()
    {
        $client = new Login('2867301');
        $bytes  = $client->get_tlv18();
        $hex    = Hex::BinToHexString($bytes);

        $this->assertTrimEquals(<<<HEX
00 18 
00 16 
00 01 
00 00 06 00 
00 00 00 00 
00 00 00 00 
00 2b c0 65 
00 00 
00 00
HEX
            , $hex, "tlv_18 should parsed as expected");
    }

    public function testTlv_1()
    {
        $client = new Login('2867301');
        $bytes  = $client->get_tlv1();
        $hex    = Hex::BinToHexString($bytes);

        $this->assertTrimEquals(<<<HEX
00 01 
00 14
00 01 
ff ff ff ff
00 2b c0 65 
ff ff ff ff
00 00 00 00
00 00
HEX
            , $hex, "tlv_1 should parsed as expected");
    }

    protected function assertTrimEquals($expected, $actual, $message = "")
    {
        $expected = preg_replace('/\s/', '', $expected);
        $actual   = preg_replace('/\s/', '', $actual);
        $this->assertEquals($expected, $actual, $message);
    }

}