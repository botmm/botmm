<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t109;
use botmm\GradeeBundle\Tlv\tlv_t124;
use botmm\GradeeBundle\Tlv\tlv_t128;
use botmm\GradeeBundle\Tlv\tlv_t144;
use botmm\GradeeBundle\Tlv\Tlv_t16e;
use botmm\tools\Cryptor;
use botmm\tools\Hex;


class Tlv144TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    public function testTlv_144()
    {
        $TGT    = random_bytes(16);
        $hexTGT = Hex::BinToHexString($TGT);
        $bytes  = (new tlv_t144())->get_tlv_144(
            $this->getTlv_109(),
            $this->getTlv_124(),
            $this->getTlv_128(),
            $this->getTlv_16e(),
            $TGT
        );
        $hex    = Hex::BinToHexString($bytes);

        $bin = Cryptor::decrypt($bytes, 4, strlen($bytes) - 4, $TGT);
        $hexDecrypt = Hex::BinToHexString($bin);
        print_r($hexDecrypt);

        $this->assertBinEqualsHex(<<<HEX
014400809973c5ba2de107770a2194504042f64da75c18d873c73c6971725be3216b1eb9dc0f9fb8058a167d73355d2a4bc1f6f6d1176cbd95dd84a87479ba67bcae048a75ee730b57e3e15e06f7cbf86fe87141083de26d2ea49bc93d6faef6ace984f6a5f40ea86b806de69b9428dab2d1e5ba4355435381162614d7c093576c04ec66
HEX
            , $hex, "tlv_1 should parsed as expected, TGT key: `{$hexTGT}`");
    }

    protected function getTlv_109()
    {
        return (new tlv_t109())->get_tlv_109(
            Hex::HexStringToBin("01 02 03 04 05 06 07 08 09 0a 0b 0c 0d 0e 0f")
        );
    }

    protected function getTlv_124()
    {
        return (new tlv_t124())->get_tlv_124(
            "android",
            "4.4.4",
            2,
            "",
            "",
            "wifi"
        );
    }

    protected function getTlv_128()
    {
        return (new tlv_t128())->get_tlv_128(
            0x00,//$newins,
            0x01,//$readguid,
            0x00,//$guidchg,
            0x01000200,//$flag,
            "Sumsung GaGa",//$devicetype,
            Hex::HexStringToBin("01 02 03 04 05 06 07 08 09 0a 0b 0c 0d 0e 0f")//$guid
        );
    }

    protected function getTlv_16e()
    {
        return (new tlv_t16e())->get_tlv_16e(
            "HUAWEI U9508"
        );
    }



}