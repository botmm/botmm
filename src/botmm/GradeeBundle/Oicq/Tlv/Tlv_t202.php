<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\GradeeBundle\Oicq\Tools\ServerTools;

class Tlv_t202 extends Tlv_t
{

    /** @var int _t202_body_len */
    protected $_t202_body_len;

    public function __construct()
    {
        parent::__construct();
        $this->_t202_body_len = 16;
        $this->_cmd           = 0x202;
    }


    /**
     * @param string      $bssid_addr md5(bssid_addr)
     * @param null|string $ssid_addr ssid_addr wifi ssid (AndroidAP ...)
     * @return
     */
    public function get_tlv_202($bssid_addr, $ssid_addr = null)
    {
        $baseAddr_Len = strlen($bssid_addr);
        if (!$baseAddr_Len) {
            $baseAddr_Len = 16;
        }
        $ssid_Len              = strlen($ssid_addr);
        $this->_t202_body_len = 2 + $baseAddr_Len + 2 + $ssid_Len;
        $body                 = new Buffer($this->_t202_body_len);
        $p                    = 0;
        $body->writeInt16BE($baseAddr_Len, $p);
        $p += 2;
        $body->write($bssid_addr, $p, $baseAddr_Len);
        $p += $baseAddr_Len;
        $body->writeInt16BE($ssid_Len, $p);
        $p += 2;
        $body->write($ssid_addr, $p, $ssid_Len);
        $p += $ssid_Len;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $p);
        $this->set_length();
        return $this->get_buf();
    }
}
