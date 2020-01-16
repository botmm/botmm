<?php
namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_ta extends Tlv_t {
    protected $_msg_len;

    public function __construct()
	{
		parent::__construct();
        $this->_msg_len = 0;
        $this->_cmd = 10;
    }

    public function verify() {
        if ($this->_body_len < 6) {
            return false;
        }
        $len = $this->_buf->readInt16BE($this->_head_len + 4);
        if ($len + 6 != $this->_body_len) {
            return false;
        }
        $this->_msg_len = $len;
        return true;
    }

    public function get_tlv_ta($in, $len) {
        $this->set_buf($in, $len);
    }

    public function get_msg() {
        if ($this->_msg_len > 0) {
            return $this->_buf->read($this->_head_len + 6, $this->_msg_len);
        }
        return '';
    }
}
