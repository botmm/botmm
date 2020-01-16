<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


class Tlv_t130 extends Tlv_t
{
    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 0x130;
    }

    public function verify()
    {
        if ($this->_body_len < 14) {
            return false;
        }
        return true;
    }

    public function get_tlv_t130($in, int $len)
    {
        $this->set_buf2($in, $len);
    }

    public function get_time()
    {
        return $this->_buf->readInt32BE($this->_head_len + 2);
    }

    public function get_ipaddr()
    {
        return $this->_buf->readInt32BE($this->_head_len + 2 + 4);

    }
}
