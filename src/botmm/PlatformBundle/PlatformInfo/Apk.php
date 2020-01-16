<?php


namespace botmm\PlatformBundle\PlatformInfo;


use botmm\GradeeBundle\Oicq\Tools\Hex;

class Apk
{

    public $version;
    public $apk_version;
    public $sign;
    public $apkId;

    public function __construct($apkInfo)
    {
        $this->version     = $apkInfo['version'];
        $this->apk_version = $apkInfo['apk_version'];
        $this->sign        = Hex::HexStringToBin($apkInfo['sign']);
        $this->apkId       = $apkInfo['apk_id'];

    }

}