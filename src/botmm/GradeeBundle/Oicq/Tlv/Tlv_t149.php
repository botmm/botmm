<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

/**
 * Class Tlv_t149
 * message
 *
 * @package botmm\GradeeBundle\Tlv
 */
class Tlv_t149 extends Tlv_t
{
    public $_content_len;
    public $_otherinfo_len;
    public $_title_len;

    public function __construct()
	{
		parent::__construct();
        $this->_title_len     = 0;
        $this->_content_len   = 0;
        $this->_otherinfo_len = 0;
        $this->_cmd           = 329;
    }

    public function verify()
    {
        if ($this->_body_len < 8) {
            return false;
        }
        $templen = $this->_buf->readInt16BE($this->_head_len + 2);
        if ($this->_body_len < $templen + 8) {
            return false;
        }
        $this->_title_len = $templen;
        $templen          = $this->_buf->readInt16BE($this->_head_len + 2 + 2 + $this->_title_len);
        if ($this->_body_len < ($this->_title_len + 8) + $templen) {
            return false;
        }
        $this->_content_len = $templen;
        $templen            = $this->_buf->readInt16BE($this->_head_len + 2 + 2 + $this->_title_len + 2 + $this->_content_len);
        if ($this->_body_len < (($this->_title_len + 8) + $this->_content_len) + $templen) {
            return false;
        }
        $this->_otherinfo_len = $templen;
        return true;
    }

    public function get_type()
    {
        return $this->_buf->readInt16BE($this->_head_len);
    }

    public function get_title()
    {
        return $this->_buf->read($this->_head_len + 2 + 2, $this->_title_len);
    }

    public function get_content()
    {
        return $this->_buf->read($this->_head_len + 2 + 2 + $this->_title_len + 2, $this->_content_len);
    }

    public function get_otherinfo()
    {
        return $this->_buf->read($this->_head_len + 2 + 2 + $this->_title_len + 2 + $this->_content_len + 2,
                                 $this->_otherinfo_len);
    }
}