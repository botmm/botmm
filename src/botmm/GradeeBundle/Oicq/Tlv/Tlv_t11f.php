<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t11f extends Tlv_t
{
    public function __construct()
    {
        parent::__construct();
        $this->_cmd        = 0x11f;
    }

    public function verify()
    {
        if ($this->_body_len < 8) {
            return false;
        }

        return true;
    }

    public function get_chg_time()
    {
        return $this->_buf->readInt32BE($this->_head_len);
    }

    public function get_tk_pri()
    {
        return $this->_buf->readInt32BE($this->_head_len + 4);
    }

}
