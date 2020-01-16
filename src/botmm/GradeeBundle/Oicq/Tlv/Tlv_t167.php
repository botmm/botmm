<?php
namespace botmm\GradeeBundle\Oicq\Tlv;

class Tlv_t167 extends Tlv_t
{
    public $_url_len;

    public function __construct()
	{
		parent::__construct();
        $this->_url_len = 0;
        $this->_cmd     = 359;
    }

    public function verify()
    {
        if ($this->_body_len < 4) {
            return false;
        }
        $len = $this->_buf->readInt16BE($this->_head_len + 1 + 1);
        if ($this->_body_len < $len + 4) {
            return false;
        }
        $this->_url_len = $len;
        return true;
    }

    public function get_img_type()
    {
        return $this->_buf->readInt8($this->_head_len);
    }

    public function get_img_format()
    {
        return $this->_buf->readInt8($this->_head_len + 1);
    }

    public function get_img_url()
    {
        return $this->_buf->read($this->_head_len + 1 + 1 + 2, $this->_url_len);
    }
}
