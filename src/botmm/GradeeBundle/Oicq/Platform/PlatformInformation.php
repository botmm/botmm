<?php


namespace botmm\GradeeBundle\Oicq\Platform;


use botmm\GradeeBundle\Oicq\Tools\Hex;
use botmm\GradeeBundle\Oicq\Tools\Util;

class PlatformInformation
{
    public $androidDevice;
    public $apkInfo;


    public $readflg = 0x01;        //imei readFlag
    //md5("Device_id + MAC address")
    public $imei          = "d1 61 60 d5 b3 56 a0 a5 4f b9 93 24 a3 63 28 6b";           // 文本型
    public $ver           = "5.8.0.157158";            // 字节集 ﻿ 5.8.0.157158
    public $appId         = 0x00000010;          // 整数型
    public $subAppId      = 0x2002ba7a;          // 整数型
    public $pcVer         = 0x1F41;
    public $clientVersion = 0x00000000;

    // md5('A0:99:9B:09:5F:FF') 这里是大写mac地址
    public $macHash = "a3 13 8a 8d d1 7e e1 a5 84 63 d7 56 83 18 0e 87";         // 文本型
    public $_apkId  = "com.tencent.mobileqq";        // 文本型

    //服务器时间
    public $initTime;
    public $clientIp = 0x00000000;
    public $sevePwd  = 1;
    public $appid    = 0x00000010;
    public $wxAppId  = 0x2002ba7a;
    //5.8 "c5 91 b0 f2 d4 51 bb 9a 5a 70 49 bf 3d 50 6e 1f"
    public $ksid     = "﻿93 AC 68 93 96 D5 7E 5F 94 96 B8 15 36 AA FE 91";

    public $osType        = "android";        // 文本型
    public $osVersion     = "4.4.2";     // 文本型
    public $_networkType  = 0x0002;  // 整数型 1表示行动网络 2表示wifi
    public $_apn          = "wifi";           // 文本型
    public $ostype        = "android";
    public $osver         = "4.4.2";
    public $nettype       = 0x0002;
    public $apn           = "wifi";
    public $netdetail     = "CMCC";
    public $addr          = "";
    public $operator_name = "CMCC";
    public $network_type  = 0x0002;

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
    public $devicetype = "MI 4LTE";
    public $deviceName = "Xiaomi";

    public $local_id = 0x00000804;

    public $appVer = "6.6.9";
    //md5(qq6.6.9的apk sign)与上面的版本对应
    public $appSign = "a6 b7 45 bf 24 a2 c2 77 52 77 16 f6 f3 6e b6 8d";

    //服务器时间
    public $time;
    public $version = "6.3.1.1993";

    //md5('A0999B095FFF0000') md5(Android Device ID)
    public $android_id = "90 06 af 4d 14 8c 18 22 88 1f 7e fe 8e 6d f2 39";

    public $requestId;//10000++

    public $ssoVer = Util::SSO_VERSION;

    /**
     * 大于1000000时重置
     * 每次请求+1, 服务端返回ssoseq
     * 重置时初始值在[60000,160000]之间
     *
     * @var int
     */
    public $ssoSeq      = 0x00016a91;
    public $userDomains = [
        "tenpay.com",
        "qzone.qq.com",
        "qun.qq.com",
        "mail.qq.com",
        "openmobile.qq.com",
        "qzone.com",
        "game.qq.com"
    ];
    //md5(imsi) SIM Subscriber ID
    //md5('460071609915509')
    public $imsi = "5f 64 aa b8 ed a2 e7 73 ca 1d 79 5d e6 19 19 68";
    //md5(bassaddr) mac md5((XX:XX:XX:XX:XX:XX).tolowercase())
    public $bssidaddr    = "fa db fa d6 6e f7 15 71 bd 7b 99 2d 9d 9c 5d b7";
    public $ssid         = "AndroidAP";
    public $source_type  = 0x00000000;
    public $product_type = 0x00000000;

    public function __construct(
        $androidDevice,
        $apkInfo
    ) {
        $this->androidDevice = $androidDevice;
        $this->apkInfo       = $apkInfo;

        $this->init();
    }

    public function init()
    {
        $this->ksid = Hex::HexStringToBin("93 33 4E AD B8 08 D3 42 82 55 B7 EF 28 E7 E8 F5");
    }

}