<?php

namespace Tests\AppBundle\Cypher;

use AppBundle\Cypher\QQCypher;
use AppBundle\Cypher\QQTEA;
use AppBundle\Cypher\Tea;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QqTeaTest extends WebTestCase
{
    public function testIndex()
    {

    }

    public function testCypher()
    {
//        $data = 'abcdef';
//        $key = pack('H*', str_replace(' ', '', '00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00'));
        $key = 'thisiskey';
        $data = "Hello World!(你好 世界!)" . microtime() . "" . rand(123456, 34567890);
        $r = QQCypher::encrypt($key, $data);

        $decrypt = QQCypher::decrypt($key, $r);

        echo bin2hex($decrypt) . "\n";

    }

    public function testTea() {
        $key = pack('H*', '78275a386d53692c562857757e2e763a');
        $data = pack('H*', "6162636465666768696a6b6c6d6e");
        $r = TEA::encrypt($data, $key);
        echo "Encrypt: \n", $this->bin2show($r);
        $b = TEA::decrypt($r, $key);
        echo "Decrypt: \n", $this->bin2show($b);
        echo "Binary String: \n", $b, "\n";
        var_dump($b === $data);
    }

    public function testTeaEncrypt() {
        $key = pack('H*', '13404B5427A13C45E69BF78147E748D8');
        $r = preg_replace('/\s/', '',
            '94 05 C5 21 B4 51 77 0C 9D C7 CB 61 90 81 5C 67
A3 05 8D 99 8E 46 FB 7B 63 4A FC 31 79 0C 90 5A
16 D2 77 AA 6D E1 B2 A4 0F 99 58 45 07 B8 D1 82
D9 71 36 8C 41 B6 87 FC 25 8D D5 6C ED D0 C2 CF
7C 46 F0 C9 E2 A3 BF 0A');
        $r = pack('H*', $r);
        $b = TEA::decrypt($r, $key);
        echo "Decrypt: \n", $this->bin2show($b);
    }
    public function testQQTea() {
        $key = 'thisiskey';
        $data = "Hello World!(你好 世界!)" . microtime() . "" . rand(123456, 34567890);
//        echo "Data: \n", $data, "\n";
        //qqtea 加密
        $r = QQTEA::encrypt($key, $data);
        echo "Encrypt: \n", $this->bin2show($r);
        //qqtea 解密
        $b = QQTEA::decrypt($key, $r);
        echo "Decrypt: \n", $this->bin2show($b);
        echo "Binary String: \n", $b, "\n";
        var_dump($b === $data);
    }

    function bin2show($bin){
        return wordwrap(trim(preg_replace('/(..)/', '$1 ', bin2hex($bin))), 0x40, "\n") . "\n";
    }

}
