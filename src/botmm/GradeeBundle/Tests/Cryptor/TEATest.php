<?php


namespace Cryptor;


use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Tools\Hex;
use botmm\GradeeBundle\Tests\Tlv\TlvTestCase;

class TEATest extends TlvTestCase
{

    public function testDec001()
    {
        $data = "
 bf ef 33 c0 20 01 55 
8f 00 06 73 29 b7 11 92 03 72 e8 a9 d3 da 38 fe 
ce 6b 9a a8 23 f8 59 ce 9d 64 f1 a8 de 0f c5 12 
a4 54 b8 1a 31 d6 1a 73 c1 73 a6 5f d7 77 ae cd 
2c e8 fa 4d f4 85 7b 70 45 d3 9b cf 05 9b 74 95 
e5 9e 53 07 6a 6b 87 d8 12 66 cc 2e d3 73 c3 6e 
44 97 b1 58 98 aa 42 3b 5d 57 8b 97 c9 03 92 e2 
aa d6 70 5a 8b 93 ee b5 ed 03 5e ea 39 50 17 04 
af b5 df b7 5d 09 f0 76 34 e0 3f 11 58 fc 0d d2 
10 cf ec cc 37 2b f8 b0 f9 75 9a 62 bf e0 11 1c 
91 fb 81 5b 06 2c 97 dc 1d 8d 03 60 db 03 54 7b 
29 4b 39 eb 3b a1 64 69 f7 79 35 e2 16 62 bc 7b 
f2 91 20 22 03 fa ef 10 84 e5 8d 41 74 fa bb 1c 
b0 90 d7 c6 77 7e c7 67 61 04 65 75 3c 42 6f c6 
9c 17 39 46 e9 74 32 2e e2 be 36 f1 c4 f8 10 9e 
0e d0 0b fe 60 ec 3c aa e3 4e 9d 1b 16 97 60 22 
31 6d 8d 3b 5c b2 08 9e ad f3 df 11 39 83 7a e6 
48 de bc f2 93 02 24 1f 32 b9 ad bc 44 30 b3 d0 
97 dd 5b a6 f6 e4 17 b8 8b 5c d1 a0 31 64 10 4e 
39 98 d6 64 29 c3 03 ee 64 44 da 8d d0 28 4c ab 
70 8e e1 3f 86 09 6d c5 92 bc 05 f0 b9 bd 1f 72 
e5 08 2b bf 18 02 a7 9d d0 95 f2 38 cb dd a3 76 
9c 9c c9 00 09 b6 28 88 b5 f5 fd 65 eb a8 e0 f6 
4c 3c 57 a7 3c 40 77 d3 70 f4 49 14 ee 92 ec 92 
02 20 1b 1d 51 a2 82 e9 8d 4d 5a c3 5a 1d 36 6c 
43 f7 38 ec a5 71 79 3c a1 35 ce 7c 8b ad 31 d6 
be 60 2a c1 c6 82 0e f4 22 bf a0 70 8f 2c c9 c9 
1f 41 8f 33 82 6e ef e8 f1 55 b4 10 3e 1f e1 14 
d8 49 dd 51 3f b8 59 ba 40 4a 96 d9 92 49 69 24 
ae 2c 0a 16 ea 3f 51 7c ad 32 80 4e dd da d2 0d 
c7 fb 2c 1f 97 1c 0c 20 d4 0a 1d 8f 8d 39 87 a5 
6b d1 7f a1 3b 6c c9 86 16 63 3a e1 36 ba 81 bb 
be ae 3a 98 7d 56 2f 5e d7 99 5e 8e 41 66 9f 32 
f4 b4 f9 e3 cc f1 f6 b2 4e

";
        $key = '00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00';
        $key  = '7d1ffc96239d17a236f122d2b497a300';//sharekey
        //$key = '74ccb6a8c92f95de435fa9c329f2c816';//md5_2+uin 123456789
        $key = md5(md5('thirstyzebra', true).hex2bin('00000000002bc065'));//md5_2+uin 12345678
        //print $key;
        //$key = md5(md5('123456', true).hex2bin('00000000002bc065'));//md5_2+uin 12345678
        //$key = 'cf 2c 33 2a 1b af 36 d0 34 9f ab 27 ac 0b 29 2c';//tmp 009 tgtgt
        //$key  = '66 6f 55 bc 4d 6b 3a 34 6c f4 b0 b1 b4 b9 6c a9';
        //$key = '67 24 2e 42 35 55 74 55 44 62 67 73 3c 38 66 58';
        //$key = '3f 25 4b 0e 79 39 59 32 55 30 9b 31 d0 ba d5 82';//101 randkey
        $key = '22 36 10 B9 E9 07 A9 16 5A 6D 38 8E AE 3C 77 48';//qqinfo randkey
        //$key = '40 6a 6b 21 7d 45 62 3f 27 4d 75 2d 68 57 2e 45';//101 sessionkey
        //$key = '04 cd 89 2d e0 90 bc e1 5c d3 a6 55 36 70 a6 b6';
        $key = "f0 de da fd 94 be a9 b2 1d 74 bb c7 10 40 61 a1";

        $str    = Hex::HexStringToBin($data);
        $result = Cryptor::decrypt($str, 0, strlen($str), Hex::HexStringToBin($key));


        $this->assertBinEqualsHex("0c", $result, "should equal");
    }

    public function testGzinflate()
    {
        //$source   = Hex::HexStringToBin("7B226170705F736967223A22EFBFBDEFBFBD45EFBFBD24EFBFBDEFBFBD7752775C7530303136EFBFBDEFBFBD6EEFBFBDEFBFBD222C226170705F6E223A22636F6D2E74656E63656E742E6D6F62696C657171222C226F73223A2232222C2262766572223A22362E332E312E31393933222C226F735F76223A22342E342E32222C22646973705F6E616D65223A225151222C226274696D65223A22323031365C2F31325C2F32382031333A35303A3432222C22646576696365223A224D4920344C5445222C226170705F76223A22362E362E39222C226B736964223A223966323638613662353231623532333364616266663561663862653531393435222C226C7374223A5B7B22737562617070223A22353337303439373232222C22617070223A223136222C2272737431223A2230222C2272737432223A2230222C226170706C697374223A2231363030303030323236222C22656D61696C223A2232383637333031222C227374617274223A2231343836333936383239222C226F706572223A22434D4343222C2261747472223A302C2275696E223A2232383637333031222C2275736564223A22343934222C2274797065223A226C6F67696E222C226C6F67223A5B7B22776170223A2233222C22706F7274223A2230222C22737562223A22307839222C22636F6E6E223A2230222C22686F7374223A22222C22726C656E223A223733222C226E6574223A2230222C2275736564223A223335222C226970223A22222C22736C656E223A22393038222C22636D64223A223078383130222C22737472223A22222C2272737432223A2230222C22747279223A2230227D2C7B22776170223A2233222C22706F7274223A2230222C22737562223A22307839222C22636F6E6E223A2230222C22686F7374223A22222C22726C656E223A2231353933222C226E6574223A2230222C2275736564223A22313338222C226970223A22222C22736C656E223A22393135222C22636D64223A223078383130222C22737472223A22222C2272737432223A2230222C22747279223A2230227D5D7D5D2C2273646B5F76223A2235227D");
        //$composed = gzcompress($source, -1, ZLIB_ENCODING_DEFLATE);
        //$composed2 = gzencode($source, -1, FORCE_DEFLATE);
        //$this->assertEquals($composed, $composed2);
        //print_r(Hex::BinToHexString($composed));
        //$uncomposed = gzuncompress($composed);
        //print_r(Hex::BinToHexString($uncomposed));

        $str = Hex::HexStringToBin("
                                    cd bf 52 07 dd 94 e3
2f 4f 26 f7 f7 8a b0 7c  9e d3 f5 5e a6 17 e4 15
b5 6a 93 28 bd c8 8f 89  b7 6f c0 1d db 17 0f 7c
fa 6d 05 2f 47 df f8 12  23 60 81 ab 73 10 13 2e
b4 7e 74 d4 72 bf 52 ec  64 84 8b 93 ec 1a 02 28
2b c4 21 4c 2c 79 f9 d9  f6 1a 08 b0 40 83 67 56
38 9b 9a b7 77 9f 97 2b  6f 85 56 19 c9 8c f9 5c
13 5c 03 db 35 aa ce 10  34 04 e7 21 40 2b 21 85
09 85 3d 16 41 38 ee 08  82 a6 5d 50 47 10 b7 cd
b8 46 45 ff 53 44 6a 1e  b1 ef b0 dd 4d d2 2a c3
09 37 fe b9 60 55 d0 fc  4a f5 87 1e 9e d7 8c 27
5b d1 9d b5 3b 35 07 e8  06 04 a6 76 3e 11 64 88
e1 66 12 4d 68 3a 47 fc  ba ed 5e 88 64 c3 68 7a
f1 5d 54 50 a5 85 ff 42  fe c1 65 55 2b c0 6e 4c
87 d1 98 8c f5 da f5 6a  66 78 56 28 92 76 11 e8
e2 3d e5 a9 47 59 48 f3  91                     
        ");

        //$bin = gzinflate($str);
        //
        $bin = gzuncompress($str);
        print_r($bin) ;
        print  "\n";
        print_r(Hex::BinToHexString($bin));

    }
}