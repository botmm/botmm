<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t126 extends Tlv_t
{
    protected $_random_len;

    public function __construct()
    {
        parent::__construct();
        $this->_random_len = 0;
        $this->_cmd        = 0x126;
    }

    public function verify()
    {
        if ($this->_body_len < 4) {
            return false;
        }

        $this->_random_len = $this->_buf->readInt16BE($this->_head_len + 2);
        if ($this->_body_len < (2 + $this->_random_len) + 2) {
            return false;
        }
        return true;
    }

    public function get_random()
    {
        return $this->_buf->read($this->_head_len + 2 + 2, $this->_random_len);
    }

}
