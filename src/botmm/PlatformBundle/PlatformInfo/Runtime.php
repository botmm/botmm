<?php


namespace botmm\PlatformBundle\PlatformInfo;


use botmm\GradeeBundle\Oicq\Tools\Util;

class Runtime
{
    public $readflg = 0x01;        //imei readFlag
    //md5("Device_id + MAC address")
    //public $imei          = "d1 61 60 d5 b3 56 a0 a5 4f b9 93 24 a3 63 28 6b";           // 文本型
    //public $ver           = "5.8.0.157158";            // 字节集 ﻿ 5.8.0.157158
    public $appId         = 0x00000010;          // 整数型
    public $subAppId      = 0x2002ba7a;          // 整数型
    public $pcVer         = 0x1F41;
    public $clientVersion = 0x00000000;

    // md5('A0:99:9B:09:5F:FF') 这里是大写mac地址
    //public $macHash = "a3 13 8a 8d d1 7e e1 a5 84 63 d7 56 83 18 0e 87";         // 文本型

    //服务器时间
    //public $initTime;
    public $clientIp = 0x00000000;
    public $sevePwd  = 1;
    public $appid    = 0x00000010;
    public $wxAppId  = 0x2002ba7a;
    //5.8 "c5 91 b0 f2 d4 51 bb 9a 5a 70 49 bf 3d 50 6e 1f"
    public $ksid = "﻿93 AC 68 93 96 D5 7E 5F 94 96 B8 15 36 AA FE 91";

    //是否第一次安装apk
    public $newinstall = 0;
    //获取不到imei则给默认 "%4;7t>;28<fc.5*6"
    public $readguid = 1;
    //imei 改变刚设置 为1
    public $guidchg = 0;

    /**
     * _dev_report
     * _guid_src  0x14 默认 "%4;7t>;28<fc.5*6"
     * _guid_src  0x11 可获取但本地无存储imei
     * _guid_src  0x01 正常
     * enum _dev_chg {
     *  md5_mac_addr    =1
     *  md5_device_id   =2
     *  md5_imei        =4
     * }
     * _dev_chg = 0 正常
     * (_guid_src << 24 & 0xff000000) | (_dev_chg << 8 & 0xff00)
     */
    public $dev_report = 0x01000000;

    public $local_id = 0x00000804;

    //协议服务器时间
    public $time    = 0x586352B2; //58 63 52 B2 //固定 [时间：2016-12-28 13:50:42]
    public $version = "6.3.1.1993";

    //md5('A0999B095FFF0000') md5(Android Device ID)
    //public $android_id = "90 06 af 4d 14 8c 18 22 88 1f 7e fe 8e 6d f2 39";

    public $requestId = 10000;//10000++

    public $ssoVer = Util::SSO_VERSION;

    /**
     * 大于1000000时重置
     * 每次请求+1, 服务端返回ssoseq
     * 重置时初始值在[60000,160000]之间
     * 0x00016a91;
     * @var int
     */
    public $ssoSeq       = 60000;

    public $userDomains  = [
        "tenpay.com",
        "qzone.qq.com",
        "qun.qq.com",
        "mail.qq.com",
        "openmobile.qq.com",
        "qzone.com",
        "game.qq.com"
    ];
    public $source_type  = 0x00000000;

    public $product_type = 0x00000000;

    public function getRequestId()
    {
        if ($this->requestId > 100000000) {
            $this->requestId = 10000;
        }
        return ++$this->requestId;
    }

    public function getSsoSeq()
    {
        if ($this->ssoSeq > 1000000) {
            $this->ssoSeq = 60000;
        }
        return ++$this->ssoSeq;
    }

    //public function getInitTime()
    //{
    //    $this->initTime = time();
    //    return time();
    //}
}