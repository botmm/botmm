<?php


namespace botmm\PlatformBundle\PlatformInfo;


use botmm\GradeeBundle\Oicq\Tools\Hex;

class Network
{
    public $bssid;
    public $ssid;
    public $networkType;
    public $operatorName;
    public $netDetail;
    public $apn;
    public $clientIp;

    public $addr = 0;

    public function __construct($network)
    {
        $this->bssid       = Hex::HexStringToBin($network['bssid']);
        $this->ssid        = $network['ssid'];
        $this->networkType = Hex::HexStringToBin($network['networkType']);
        $this->netDetail   = $network['netDetail'];
        $this->operatorName = $this->netDetail;
        $this->apn         = $network['apn'];
        $this->mac         = Hex::HexStringToBin($network['mac']);
        $this->clientIp    = $network['client_ip'];
    }


    public function getHashMac()
    {
        return md5($this->mac, true);
    }

}