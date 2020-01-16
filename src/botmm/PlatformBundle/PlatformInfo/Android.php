<?php


namespace botmm\PlatformBundle\PlatformInfo;


use botmm\GradeeBundle\Oicq\Tools\Hex;

class Android
{

    public $imei;
    public $version;
    public $appId;
    public $pcVersion;
    public $osType;
    public $osVersion;
    public $imsi;
    public $networkType;
    public $netDetail;
    public $apn;
    public $device;
    public $deviceType;
    public $deviceName;
    public $guid;
    public $deviceBrand;
    public $android_device_id;
    /**
     * 网络环境md5, 在java中可能用的是imei变量名
     * @var string
     */
    public $android_device_mac_hash;

    public function __construct($androidInfo)
    {
        $this->imei        = $androidInfo['imei'];
        $this->version     = $androidInfo['version'];
        $this->appId       = Hex::HexStringToBin($androidInfo['appId']);
        $this->pcVersion   = Hex::HexStringToBin($androidInfo['pcVersion']);
        $this->osType      = $androidInfo['osType'];
        $this->osVersion   = $androidInfo['osVersion'];
        $this->imsi        = Hex::HexStringToBin($androidInfo['imsi']);
        $this->device      = $androidInfo['device'];
        $this->deviceType  = $androidInfo['deviceType'];
        $this->deviceName  = $androidInfo['deviceBrand'];
        $this->guid        = Hex::HexStringToBin($androidInfo['guid']);
        $this->deviceBrand = $androidInfo['deviceBrand'];

        $this->android_device_id = Hex::HexStringToBin($androidInfo['android_device_id']);
        $this->android_device_mac_hash = Hex::HexStringToBin($androidInfo['android_device_mac_hash']);
    }
}