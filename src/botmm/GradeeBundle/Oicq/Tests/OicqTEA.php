<?php


namespace Cryptor;


use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Tools\Hex;
use botmm\GradeeBundle\Tests\Tlv\TlvTestCase;

class QicqTEA extends TlvTestCase
{

    public function testDec001()
    {
        $data = "
77 7e 4b 63 d6 02 02 e9 ec 12 cd 12 eb 8f 4f 9c b4 9b 78 c2 ca 97 3e 19 0a e4 ea 74 fa ad 90 3f b5 90 57 13 ab da 41 c6 dc 09 e6 9d 34 c2 1c 39 cc 43 0a 1d 81 aa 5a e0 da 22 da 6a 52 f9 77 73 3e b0 bd 6b 74 2f 2f 2b 27 e2 93 8d 83 c2 37 9e 92 ad ff 58 33 c0 6a d1 18 ee ad 16 03 26 d2 6e b6 75 c3 e5 f1 88 3c af 91 44 87 80 24 b1 a3 13 81 d3 f9 7c 81 93 dd 72 4c 6c b6 d0 d5 1b b8 24 8e 77 a7 bd 01 b3 5d 71 cb bb 72 42 9f 07 b2 93 15 c6 e5 c2 68 d3 b2 54 7a 9d 09 5e bf f0 c4 07 39 15 bb 3b 19 e9 51 aa bf 69 f7 46 1a 7c cc 7e a7 39 57 ef 98 f5 44 c6 c0 88 be 07 9f a6 ce 14 27 ea e0 7f be 07 d6 84 00 2e cd 5a 91 ae 13 1e 80 06 7d a2 78 e4 8e b5 9c 3c c7 64 14 b0 69 6b 84 05 a1 c8 2d b8 7b a4 41 be f3 7a bc 4e b3 cc 20 c3 8c 3f 69 50 0a b5 17 93 3f ad 7f a0 e2 18 30 10 dd ee 5b e1 98 bc ba 8f d9 d4 54 0f 8e 4e 8c 91 af be a4 0c 10 ff b9 fe 15 87 ff b9 70 d1 56 d5 a8 d2 3b 1b 0a 0e 86 53 c7 50 e8 ad c6 12 21 1c 84 1b cd 12 79 96 fe 96 ce a3 64 43 ca 97 fe 0c ab f0 28 a5 16 53 c8 a4 64 ce bf 4a 63 b6 69 93 46 98 29 4a ce 8f 20 b7 01 b9 bd cf 0b 54 a9 37 8f 87 c3 83 52 28 47 e5 cc 24 5e 27 85 a9 bc ab 11 e6 22 36 af cd 11 b7 df 37 43 05 b0 b4 12 10 86 2f 2d e0 15 8b 66 d0 30 04 06 24 62 bd fb e3 3e 75 48 76 a1 41 63 ad 39 75 8e d3 d1 6d 96 00 16 1c ac ba 95 ed 7e e2 2c a9 98 7c 24 f9 19 ca 39 14 10 ee 4b b3 c2 cf 84 aa b8 fb 5c 0f f4 24 fa 95 ce 47 00 81 ae 60 5d 24 72 f8 1f 21 89 88 5f b5 c0 bd f7 74 b4 40 98 aa 6a 95 2c 0a c5 74 33 29 bb ec 2d 89 ec 44 f2 05 e4 7d 47 c4 99 b6 4f 61 74 d5 8b 90 26 ec 74 32 79 a9 67 48 b3 04 6a 17 d1 6f 52 18 e8 a4 a5 ed 9e 97 a0 a1 55 12 91 1c 87 cd f7 42 47 ec 1d ec 60 1c 0a 49 99 89 1e 0c e5 cb 3a ff 52 42 ec a3 83 4e fe 87 5a 31 11 0d 29 7f 03 26 b0 d2 1d 1f 9b c9 b6 08 3d c2 83 c8 de 0b 1c 89 72 bb 5c aa 79 4f bb 59 e4 7e 9d e7 46 d1 52 87 07 00 a0 39 c0 3e 7d 50 fc 9f 53 9e 41 e5 f4 b7 13 07 bb 01 a4 ca 08 83 22 07 b1 8f 18 eb 96 b8 bd f5 4c b7 16 55 f9 60 34 d7 ed 0f b1 71 63 db eb fb 56 af e1 e0 a6 3e eb af 71 dc 1b 85 a1 5e a2 52 83 e9 b2 42 e3 4d 11 59 60 c1 09 69 cf f7 d6 ca 55 ba 8d 0a 04 b5 42 44 48 1e 60 36 8f da e2 70 3c 70 80 c3 9a d8 28 d5 81 46 cf e5 32 92 05 8d 58 13 2b e9 94 82 18 8f 85 74 06 02 c6 6d 6c 59 6e 75 88 35 4f 58 79 13 6e b9 da 09 f9 6f b0 d6 96 85 9e 0f 00 c0 4e 8e 02 41 9e 43 91 13 bf 4b 59 84 92 ff 1c 64 6a ac 54 5c c7 f1 b9 a1 b2 59 ab 04 44 11 1f 82 cd c5 ae 5d 19 2d 08 f6 68 02 91 33 57 09 24 a2 81 e1 ce f9 a8 4d 62 41 80 c9 b7 29 25 04 04 84 43 3c 1b 56 16 ef e1 4a 00 2b 36 e2 67 40 f8 b7  ";
        //$key    = '4da0f614fc9f29c2054c77048a6566d7';
        //$key = '76 c9 a6 37 9c 3c 6d 8e 3c a9 5a 89 b3 d0 b8 67';
        //$key = '00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00';
        $key  = '7d 1f fc 96 23 9d 17 a2 36 f1 22 d2 b4 97 a3 00';//sharekey
        //$key = '2d 1a 25 bc 4c 96 9d 65 8b b6 ee 62 26 30 86 42 ';//md5_2+uin

        $str    = Hex::HexStringToBin($data);
        $result = Cryptor::decrypt($str, 0, strlen($str), Hex::HexStringToBin($key));

        $this->assertBinEqualsHex("0c", $result, "should equal");
    }
}