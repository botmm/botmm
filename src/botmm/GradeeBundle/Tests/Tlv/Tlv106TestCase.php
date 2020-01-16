<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Tlv\tlv_t106;
use botmm\tools\Hex;
use botmm\tools\ServerTools;


class Tlv106TestCase extends TlvTestCase
{

    protected $uin = 2867301;

    /**
     * ﻿.版本 2
     * 01 06
     * 00 70 [md5(md5(pass)+0 0 0 0+hexQQ)E8 FD 5B 08 BF 42 3C B9 F8 D4 23 30 F2 E2 E3 59 ]
     * 67 A4 4D 1D 59 08 97 15 92 03 BB E3 E8 7F 49 CC 65 A2 F6 E3 4F 68 DA 9E A2 E9 DA 90 DB 26 2D F5 A4 BD C0 52 51
     * F0 40 77 B5 50 25 42 AC 68 1B 57 35 61 97 65 36 6B AA 35 C5 E1 E6 C8 91 3B 3E 30 84 AA 6F 6C 32 29 97 FB DF 53
     * CA 3C B5 F8 F3 13 E4 FF AA 58 39 75 81 45 38 4A A2 BE CA 43 E0 7E 0A 83 71 17 5C 88 7C DE DE ED B8 12 E4 D5 C4
     * 22
     * [
     * 00 03 //TGTGTVer=3
     * 29 A5 69 34 rand32
     * 00 00 00 05 sso_ver
     * 00 00 00 10 appid
     * 00 00 00 00 client ver
     * 00 00 00 00 18 B4 A1 BC [QQ:414491068]
     * 4D 1F C3 AC //时间
     * 00 00 00 00 client ip
     * 01
     * EB E0 80 63 34 8C 9E E1 FD 6B 5E 05 9A 72 84 C6 //MD5PASS
     * C5 2E 0F 5D A6 20 B5 EE 0B 94 F2 6F C3 05 4A 02 //TGTKey
     * 00 00 00 00
     * 01 readflag
     * 46 60 1E D3 C6 24 16 BF CA A2 9E 9E B8 9A D2 4E //imei_
     * 20 02 93 92 _sub_appid
     * 00 00 00 01 00 00
     * ]
     * time ＝Xbin.Flip 取字节集左边 (到字节集 (Other.TimeStamp ()), 4))
     */
    public function testTlv_106()
    {
        $bytes = (new tlv_t106())->get_tlv_106(
            Hex::HexStringToBin("00 00 00 10"),
            0,
            Hex::HexStringToBin("00 00 00 00"),
            $this->uin,
            ServerTools::get_server_cur_time(),
            0,//$client_ip,
            1,//$seve_pwd,
            md5('thirstyzebra', true),
            random_bytes(16),
            1,//$readflg,
            hex::HexStringToBin("46 60 1E D3 C6 24 16 BF CA A2 9E 9E B8 9A D2 4E")//$guid imei
        );
        $hex   = Hex::BinToHexString($bytes);

        $this->assertBinEqualsHex(<<<HEX
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


}