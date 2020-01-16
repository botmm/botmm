<?php

namespace botmm\tools\Cypher\Tests;

use botmm\GradeeBundle\Tests\Tlv\TlvTestCase;
use botmm\tools\Cypher\Tea;
use botmm\tools\Hex;

class QqTeaTest extends TlvTestCase
{
    public function testIndex()
    {

    }

    public function testCypher01()
    {
        $data = '
00 00 00 E5 //total length 

00 00 00 08 
02 00

00 00 00 0B //qq length
32 38 36 37 33 30 31 //qq

01EC9098CA1431D0124ACD2BD0697A86BDA4DF48561CFC76D066700F9BF052247630F3494DDD5E8A27462D66AFB9DEA9AA8B4497F2E9B31AA2E7BE828E87E5F49013BD7C9CBA2AC8B63DE8DCE44C7EE7EB50C478C4764813C7F9878BB1EF26769DB4D573FE768829A2C14C944DD0874CDA0D5C01BE11E9CF0B8403508B635D6A9CBB65D949F2E41474BA928770DBCBC8310C732B64370BF5FEA9185E8E28CE405508A5BA81535EFAF86101F150307FC440A3F4E96CAF86A623D038A50DB219263DF5EEE0BC9062B45159D0440A27865E';

        $data   = "
01 EC 90 98 CA 14 31 D0 12 4A CD 
2B D0 69 7A 86 BD A4 DF 48 56 1C FC 76 D0 66 70 
0F 9B F0 52 24 76 30 F3 49 4D DD 5E 8A 27 46 2D 
66 AF B9 DE A9 AA 8B 44 97 F2 E9 B3 1A A2 E7 BE 
82 8E 87 E5 F4 90 13 BD 7C 9C BA 2A C8 B6 3D E8 
DC E4 4C 7E E7 EB 50 C4 78 C4 76 48 13 C7 F9 87 
8B B1 EF 26 76 9D B4 D5 73 FE 76 88 29 A2 C1 4C 
94 4D D0 87 4C DA 0D 5C 01 BE 11 E9 CF 0B 84 03 
50 8B 63 5D 6A 9C BB 65 D9 49 F2 E4 14 74 BA 92 
87 70 DB CB C8 31 0C 73 2B 64 37 0B F5 FE A9 18 
5E 8E 28 CE 40 55 08 A5 BA 81 53 5E FA F8 61 01 
F1 50 30 7F C4 40 A3 F4 E9 6C AF 86 A6 23 D0 38 
A5 0D B2 19 26 3D F5 EE E0 BC 90 62 B4 51 59 D0 
44 0A 27 86 5E ";
        $key    = '00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00';
        $result = TEA::decrypt(Hex::HexStringToBin($data), Hex::HexStringToBin($key));

        $this->assertBinEqualsHex(
"00 00 00 2d 
00 00 27 10 
00 00 00 00 
00 00 00 04 
00 00 00 11 
77 74 6c 6f 67 69 6e 2e 6c 6f 67 69 6e 
00 00 00 08 
d6 34 99 45 
00 00 00 00 
00 00 00 95 
02 
00 91 
1f 41 08 10 00 01 00 2b c0 65 

00 00 
01 

09 4d 27 6f dd c3 73 05 02 f3 9b 36 bd 92 9e e3 
34 99 dd 8f e8 65 5b af e7 d4 29 e6 06 a6 4b 6d 
57 68 5d 85 e8 91 e6 bf a0 cc 7d 3a 9e d1 ec e1 
7a cb 8e 6b 44 7f a7 64 1e 9f af 80 1c 68 2f f7 
84 e6 c4 88 bb f6 0e e3 fd f2 cf cb 84 99 4c a7 
87 27 a3 15 f2 9e d3 4b 0d cf 21 47 81 a8 43 12 
33 c8 12 0f 0a a8 75 01 72 a0 85 5a 3b e0 9c 3a 
12 0d d8 71 c2 6a fe ea ea e2 1e 6a 90 6a a9 d5
 
03",
$result, "decode return code");


    }


    public function testCypher02()
    {
        $data = <<<HEX
D8 DB E6 C2 60 9E D2 7B 7A C4 5D 07 64 90 65 11 
34 2C 5B 8A 55 92 2A 07 96 32 81 06 1E 62 E1 CB 
0B CE 85 80 19 44 7C F1 AF AA BC 40 B6 24 B5 95 
93 AC B6 22 C7 B7 53 97 43 EC BA B4 11 0C 23 DA 
FC 77 BE A1 75 57 C9 74 32 CE BD F8 3D 71 0F F6 
E4 19 06 57 97 1C 26 A7 54 95 79 48 23 69 89 94 
5D A9 9B 51 59 F9 EB EC 0B 22 E4 F1 13 71 8D 2D 
58 59 4F C4 3E D9 DB 75 80 7A 22 31 1A 82 4C FA 
99 DC 6C 20 47 18 CF 7C 00 E9 7B 6E C2 73 B3 97 
41 F3 5A 5C 5D 9B 33 DF 30 20 61 DF A3 21 4F E0 
06 F2 7A 3D 7B 21 89 C1 4C DC 04 59 4A D3 00 C2 
86 23 03 79 C0 44 E0 39 AD D5 45 09 20 97 3A F2 
48 DB F5 FE 3D FB F7 F2 04 38 96 B2 DA F2 41 A2
HEX;
        //B1
        $key    = '00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00';
        $result = TEA::decrypt(Hex::HexStringToBin($data), Hex::HexStringToBin($key));

        echo Hex::BinToHexString(($result));
        $s = "
00 00 00 2d //45 bytes
00 00 27 10 //sso

00 00 00 00 

00 00 00 04
 
//wtlogin.login
00 00 00 11 
77 74 6c 6f 67 69 6e 2e 6c 6f 67 69 6e 

00 00 00 08 
6a cc c9 00 
00 00 00 00 
//end of 45 bytes

00 00 00 95 

02 
00 91 
//10bytes
1f 41 08 10 00 01 00 2b c0 65 

00 00
 
01 //登录结果 01密码不正确 02需要验证码

3d 8a ce 5f 3c c3 09 10 87 5e e2 d4 80 d7 89 ae 
1d 29 8e aa fd a4 7a 0f 01 08 a5 e9 48 d1 2d aa 
9e eb b6 0c bf c3 af 14 fe 1e e7 fe f3 09 a4 0f 
38 0f 28 67 99 4c 58 25 5e 5c d1 eb 08 9d b6 92 
59 67 b8 06 d6 fd d5 7e 2f ad ef dd 8f 30 6a 2f 
57 b1 ff 4b be 73 ff 7d 31 35 16 13 1a 51 14 84 
a2 54 05 a9 00 2e 91 d9 b9 3d 35 bd 14 cb c9 e3 
83 c7 f2 e6 82 55 5d 91 6d 9f e7 84 c7 4c 04 70

03
";


    }


    public function testDec()
    {
        $data = "
09 4D 27 6F DD C3 73 05 02 F3 9B 36 BD 92 9E E3 
34 99 DD 8F E8 65 5B AF E7 D4 29 E6 06 A6 4B 6D 
57 68 5D 85 E8 91 E6 BF A0 CC 7D 3A 9E D1 EC E1 
7A CB 8E 6B 44 7F A7 64 1E 9F AF 80 1C 68 2F F7 
84 E6 C4 88 BB F6 0E E3 FD F2 CF CB 84 99 4C A7 
87 27 A3 15 F2 9E D3 4B 0D CF 21 47 81 A8 43 12 
33 C8 12 0F 0A A8 75 01 72 A0 85 5A 3B E0 9C 3A 
12 0D D8 71 C2 6A FE EA EA E2 1E 6A 90 6A A9 D5";
        $data = "
09 4d 27 6f dd c3 73 05 02 f3 9b 36 bd 92 9e e3 
34 99 dd 8f e8 65 5b af e7 d4 29 e6 06 a6 4b 6d 
57 68 5d 85 e8 91 e6 bf a0 cc 7d 3a 9e d1 ec e1 
7a cb 8e 6b 44 7f a7 64 1e 9f af 80 1c 68 2f f7 
84 e6 c4 88 bb f6 0e e3 fd f2 cf cb 84 99 4c a7 
87 27 a3 15 f2 9e d3 4b 0d cf 21 47 81 a8 43 12 
33 c8 12 0f 0a a8 75 01 72 a0 85 5a 3b e0 9c 3a 
12 0d d8 71 c2 6a fe ea ea e2 1e 6a 90 6a a9 d5";
        $data = "
3d 8a ce 5f 3c c3 09 10 87 5e e2 d4 80 d7 89 ae 
1d 29 8e aa fd a4 7a 0f 01 08 a5 e9 48 d1 2d aa 
9e eb b6 0c bf c3 af 14 fe 1e e7 fe f3 09 a4 0f 
38 0f 28 67 99 4c 58 25 5e 5c d1 eb 08 9d b6 92 
59 67 b8 06 d6 fd d5 7e 2f ad ef dd 8f 30 6a 2f 
57 b1 ff 4b be 73 ff 7d 31 35 16 13 1a 51 14 84 
a2 54 05 a9 00 2e 91 d9 b9 3d 35 bd 14 cb c9 e3 
83 c7 f2 e6 82 55 5d 91 6d 9f e7 84 c7 4c 04 70";

        $key    = '95 7C 3A AF BF 6F AF 1D 2C 2F 19 A5 EA 04 E5 1C';
        $result = TEA::decrypt(Hex::HexStringToBin($data), Hex::HexStringToBin($key));

        $this->assertBinEqualsHex(
"00 09 01 00 02 01 46 00 42 00 00 00 01 00 0c e7 
99 bb e5 bd 95 e5 a4 b1 e8 b4 a5 00 2a e5 b8 90 
e5 8f b7 e6 88 96 e5 af 86 e7 a0 81 e9 94 99 e8 
af af ef bc 8c e8 af b7 e9 87 8d e6 96 b0 e8 be 
93 e5 85 a5 e3 80 82 00 00 00 00 05 08 00 22 01 
00 00 0b b8 00 1b 02 00 00 00 10 20 02 9f 53 08 
10 00 00 00 01 00 00 00 00 00 2b c0 65 00 00 00 
01", $result);
    }

    public function testDecStep4() {
        $data =
"00 09 
01 //return code
00 02 

//tlv146
01 46 
00 42 //body长度

00 00 //ver
00 01 //code

00 0c //长度 
//登录失败
e7 99 bb e5 bd 95 e5 a4 b1 e8 b4 a5
00 2a 长度
//*帐号或密码错误，请重新输入。
e5 b8 90 e5 8f b7 e6 88 96 e5 af 86 e7 a0 81 e9 94 99 e8 af af ef bc 8c e8 af b7 e9 87 8d e6 96 b0 e8 be 93 e5 85 a5 e3 80 82 00 
//end of tlv146

//无用数据
00 00 00 05 08 00 22 01 00 00 0b b8 00 1b 02 00 
00 00 10 20 02 9f 53 08 10 00 00 00 01 00 00 00 
00 00 2b c0 65 00 00 00 01";

        echo Hex::HexStringToBin("e7 99 bb e5 bd 95 e5 a4 b1 e8 b4 a5 00 
2a e5 b8 90 e5 8f b7 e6 88 96 e5 af 86 e7 a0 81 e9 94 99 e8 af af ef bc 8c e8 af b7 e9 87 8d e6 96 b0 e8 be 93 e5 85 a5 e3 80 82 00 
");

    }
}
