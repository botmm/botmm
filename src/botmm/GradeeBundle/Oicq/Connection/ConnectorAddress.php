<?php

namespace botmm\connection;

use Madkom\RegEx\Matcher;
use Madkom\RegEx\Pattern;

class ConnectorAddress
{
    public $protocol;
    public $host;
    public $port;

    public $gsm;
    public $flag1;
    public $flag2;

    /**
     *
     * "socket://211.136.236.89:14000#46000_46002:0:1"
     * "socket://211.136.236.90:14000#46000_46002:0:1"
     * "socket://112.90.140.220:14000#46001:0:1"
     * "socket://112.90.140.221:14000#46001:0:1"
     * "socket://113.108.90.48:14000#46003:0:1"
     * "socket://113.108.90.49:14000#46003:0:1"
     * "socket://202.55.10.141:8080#46000_46002_46001_46003:0:1"
     * "socket://202.55.10.141:14000#46000_46002_46001_46003:0:1"
     * "socket://msfwifi.3g.qq.com:8080#00000:0:1"
     * "socket://113.108.90.53:8080#00000:0:1"
     * "socket://120.196.210.32:8080#00000:0:1"
     * "socket://120.196.210.30:8080#00000:0:1"
     * "socket://112.90.140.143:8080#00000:0:1"
     * "socket://112.64.234.200:8080#00000:0:1"
     * "socket://202.55.10.141:8080#00000:0:1"
     * "socket://202.55.10.141:14000#00000:0:1"
     * ([a-zA-Z]+)://   http:// group 1     protocol
     * ([a-zA-Z0-9.]+)  0.0.0.0 group 2     host
     * (:([0-9]+))?     :0      group 3 4   port
     * (#([0-9_]*))?    #num_   group 5 6   00000 代表任意, 46000_46002_46001_46003 移动联通电信
     * (:([0-9]+))?     :0      group 7 8
     * (:([0-9]+))?     :0      group 9 10

     */
    public function __construct()
    {

    }

    public static function parseAddress($addressString)
    {
        $address = new static();

        $pattern = new Pattern("([a-zA-Z]+)://([a-zA-Z0-9.]+)(:([0-9]+))?(#([0-9_]*))?(:([0-9]+))?(:([0-9]+))?");
        $matcher = new Matcher($pattern);
        $matches = $matcher->match($addressString);
        if ($matches) {
            if ($matches[1] != null) {
                $address->protocol = $matches[1];
            }
            if ($matches[2] != null) {
                $address->host = $matches[2];
            }
            if ($matches[4] != null) {
                $address->port = $matches[4];
            }
            if ($matches[6] != null) {
                $address->gsm = $matches[6];
            }
            if ($matches[8] != null) {
                $address->flag1 = $matches[8];
            }
            if ($matches[10] != null) {
                $address->flag2 = $matches[10];
            }
        }

        return $address;
    }
}