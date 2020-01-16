<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t172 extends Tlv_t
{
    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 370;
    }

    public function get_tlv_172($rollbackSig)
    {
        $body = new Buffer();
        $pos  = 0;
        $body->write($rollbackSig, $pos);
        $pos += strlen($rollbackSig);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $pos);
        $this->set_length();
        return $this->get_buf();
    }
}

