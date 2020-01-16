<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t109 extends Tlv_t
{
    protected $_t109_body_len;

    public function __construct()
	{
		parent::__construct();
        $this->_t109_body_len = 0;
        $this->_cmd           = 265;
    }

    public function get_tlv_109($IMEI)
    {
        $this->_t109_body_len = strlen($IMEI);
        $body                 = new Buffer($this->_t109_body_len);
        $body->write($IMEI, 0);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t109_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}
