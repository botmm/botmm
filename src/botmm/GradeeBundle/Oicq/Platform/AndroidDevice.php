<?php


namespace botmm\GradeeBundle\Oicq\Platform;


class AndroidDevice
{
    public $imei;           // 文本型
    public $imei_;          // 字节集
    public $ver;            // 字节集
    public $appId;          // 整数型
    public $pc_ver;         // 文本型
    public $os_type;        // 文本型
    public $os_version;        // 文本型
    public $_network_type;        // 整数型
    public $_apn;        // 文本型
    public $device;        // 文本型
}