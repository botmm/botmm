<?php


namespace botmm\GradeeBundle\Oicq\Platform;


class QqInfo
{

    public $Account;        // 文本型       qq
    public $QQ;             // 长整数型     qq 10
    public $uin;            // 64位
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
    public $TGTKey;         // 字节集
    public $shareKey;       // 字节集
    public $pub_key;        // 字节集
    public $_ksid;          // 字节集
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
    public $bitmap;
    public $get_sig = 0x021610e0;
    public $picType;
    public $capType;
    public $picSize;
    public $retType;


}