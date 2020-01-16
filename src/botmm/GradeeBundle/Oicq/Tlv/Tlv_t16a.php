<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t16a extends Tlv_t
{
    protected $_t16a_body_len;

    public function __construct()
    {
        parent::__construct();
        $this->_t16a_body_len = 0;
        $this->_cmd           = 0x16a;
    }

    public function get_tlv_16a($no_pic_sig)
    {
        $this->_t16a_body_len = strlen($no_pic_sig);
        $body                 = new Buffer($this->_t16a_body_len);
        $body->write($no_pic_sig, 0);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t16a_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}
