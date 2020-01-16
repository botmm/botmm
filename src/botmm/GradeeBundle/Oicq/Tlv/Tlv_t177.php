<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t177 extends Tlv_t
{
    protected $_t177_body_len = 0;

    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 375;
    }

    /**
     *
     * @param        $time    1400575203
     * @param string $version "5.2.2.1"
     * @return mixed
     */
    public function get_tlv_177($time, $version = "")
    {
        $version_len           = strlen($version);
        $this->_t177_body_len = $version_len + 7;
        $body                 = new Buffer($this->_t177_body_len);
        $p                    = 0;
        $body->writeInt8(1, $p);
        $p += 1;
        $body->writeInt32BE($time, $p);
        $p += 4;
        $body->writeInt16BE($version_len, $p);
        $p += 2;
        $body->write($version, $p, $version_len);
        $p += $version_len;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t177_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}