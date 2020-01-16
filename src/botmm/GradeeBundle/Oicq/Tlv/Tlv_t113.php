<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t113 extends Tlv_t
{
    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 0x113;
    }

    public function get_uin()
    {
        return $this->_buf->readInt32BE($this->_head_len);
    }
}

