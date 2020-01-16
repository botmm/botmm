<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t105 extends Tlv_t
{
    protected $_en_pos;
    protected $_enlen;
    protected $_pic_pos;
    protected $_piclen;

    public function __construct()
	{
		parent::__construct();
        $this->_piclen  = 0;
        $this->_enlen   = 0;
        $this->_pic_pos = 0;
        $this->_en_pos  = 0;
        $this->_cmd     = 0x105;
    }

    public function verify()
    {
        if ($this->_body_len < 2) {
            return false;
        }
        $this->_enlen = $this->_buf->readInt16BE($this->_head_len);
        if ($this->_body_len < ($this->_enlen + 2) + 2) {
            return false;
        }
        $this->_piclen = $this->_buf->readInt16BE($this->_head_len + 2 + $this->_enlen);
        if ($this->_body_len < (($this->_enlen + 2) + 2) + $this->_piclen) {
            return false;
        }
        $this->_en_pos  = $this->_head_len + 2;
        $this->_pic_pos = (($this->_enlen + 2) + 2) + $this->_head_len;
        return true;
    }

    public function get_pic()
    {
        if ($this->_piclen > 0) {
            $this->_buf->read($this->_pic_pos, $this->_piclen);
        }
        return '';
    }

    public function get_sign()
    {
        return $this->_buf->read($this->_en_pos, $this->_enlen);
    }
}
