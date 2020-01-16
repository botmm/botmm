<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


class Tlv_t150 extends Tlv_t
{
    public $_other_len;

    public function __construct()
	{
		parent::__construct();
        $this->_other_len = 0;
        $this->_cmd       = 336;
    }

    public function verify()
    {
        if ($this->_body_len < 7) {
            return false;
        }
        $templen = $this->_buf->readInt16BE($this->_head_len + 5);
        if ($this->_body_len < $templen + 7) {
            return false;
        }
        $this->_other_len = $templen;
        return true;
    }

    public function get_bitmap()
    {
        $this->_buf->readInt32BE($this->_head_len);
    }

    public function get_network()
    {
        return $this->_buf->readInt8($this->_head_len + 4);
    }
}
