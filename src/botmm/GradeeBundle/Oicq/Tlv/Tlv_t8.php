<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t8 extends Tlv_t
{

    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 8;
    }

    public function get_tlv_8($paramInt1, $_local_id, $paramInt3)
    {
        $body = new Buffer(8);
        $p    = 0;
        $body->writeInt16BE($paramInt1, 0);
        $p += 2;
        $body->writeInt32BE($_local_id, 0);
        $p += 4;
        $body->writeInt16BE($paramInt3, 0);
        $p += 2;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, 8);
        $this->set_length();
        return $this->get_buf();
    }
}