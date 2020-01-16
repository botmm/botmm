<?php

namespace botmm\PlatformBundle\PlatformInfo;


use botmm\GradeeBundle\Oicq\Tools\Hex;

class QqInfo
{

    public $Account;        // 文本型       qq
    public $QQ;             // 文本型     qq 10
    public $uin;            // 64位
    public $ksid;           // 字节集
    public $user;           // 字节集       qq_hex
    public $caption;        // 字节集       qq_utf-8
    public $pass;           // 文本型
    public $md5;            // 字节集
    public $md52;           // 字节集
    public $time;           // 字节集
    public $key;            // 字节集
    public $nick;           // 文本型
    public $Token002C;      // 字节集
    public $Token004C;      // 字节集      A2
    public $Token0058;      // 字节集
    //public $TGTKey;         // 字节集
    public $shareKey;       // 字节集
    public $pubKey;        // 字节集
    public $randKey;        // 字节集
    public $mST1Key;        // 字节集      transport秘药
    public $stweb;          // 文本型
    public $skey;           // 字节集
    public $pskey;          // 字节集      01 6C 暂时没返回
    public $superkey;       // 字节集      01 6D 暂时没返回
    public $vkey;           // 字节集
    public $sid;            // 字节集
    public $sessionKey;     // 字节集
    public $loginState;     // 整数型      登陆是否验证成功
    public $VieryToken;     // 字节集      验证码token
    public $VieryToken2;    // 字节集      验证码token
    public $Viery;          // 字节集      验证码

    public $TGTGT;
    public $bitmap  = 0x57ff7c; //WtloginHelper mMiscBitmap
    public $get_sig = 0x10400; //WtloginHelper mSubSigMap
    public $picType;
    public $capType;
    public $picSize;
    public $retType;

    public $rollbackSig;

    public function __construct($qq, $pwd)
    {
        $this->QQ   = $qq;
        $this->uin  = intval($qq);
        $this->md5  = md5($pwd, true);
        $this->md52 = md5($this->md5 . $this->pack64($this->uin));


        //$this->ksid = Hex::HexStringToBin('c5 91 b0 f2 d4 51 bb 9a 5a 70 49 bf 3d 50 6e 1f');

        $this->TGTGT = random_bytes(16);

        $this->randKey  = Hex::HexStringToBin("22 36 10 B9 E9 07 A9 16 5A 6D 38 8E AE 3C 77 48");
        $this->pubKey   = Hex::HexStringToBin("03 4B 6B 9F 22 CE C8 67 83 97 87 AA 32 06 7A E2 B3 BD 9D 57 8F 20 97 6D B4");
        $this->shareKey = Hex::HexStringToBin("7d 1f fc 96 23 9d 17 a2 36 f1 22 d2 b4 97 a3 00");

        $this->key      = Hex::HexStringToBin("00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00");
    }


    private function pack64($value)
    {
        $highMap = 0xffffffff00000000;
        $lowMap  = 0x00000000ffffffff;
        $higher  = ($value & $highMap) >> 32;
        $lower   = $value & $lowMap;
        $packed  = pack('NN', $higher, $lower);
        return $packed;
    }

}