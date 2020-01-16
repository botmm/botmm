<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t129 extends Tlv_t
{
    protected $_random_len;

    public function __construct()
    {
        parent::__construct();
        $this->_random_len = 0;
        $this->_cmd        = 0x129;
    }

    public function verify()
    {
        if ($this->_body_len < 8) {
            return false;
        }

        return true;
    }

    public function get_timeout()
    {
        return $this->_buf->readInt32BE($this->_head_len);
    }

    public function get_nexttime()
    {
        return $this->_buf->readInt32BE($this->_head_len + 4);
    }

}
