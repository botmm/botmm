<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


class Tlv_t132 extends Tlv_t
{


    protected $_openid_len;
    protected $_token_len;

    public function __construct()
    {
        parent::__construct();
        $this->_token_len  = 0;
        $this->_openid_len = 0;
        $this->_cmd        = 0x132;
    }

    public function verify()
    {
        if ($this->_body_len < 2) {
            return false;
        }
        $this->_token_len = $this->_buf->readInt16BE($this->_head_len);
        if ((($this->_token_len + 2) + 4) + 2 > $this->_body_len) {
            return false;
        }
        $this->_openid_len = $this->_buf->readInt16BE((($this->_head_len + 2) + $this->_token_len) + 4);
        return true;
    }

    public function get_access_token()
    {
        return $this->_buf->read($this->_head_len + 2, $this->_token_len);
    }

    public function get_openid()
    {
        return $this->_buf->read($this->_head_len + 2 + $this->_token_len + 4 + 2, $this->_openid_len);
    }
}
