<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t2 extends Tlv_t
{
    /** @var int _sigVer */
    protected $_sigVer;
    /** @var int _t2_body_len */
    protected $_t2_body_len;

    public function __construct()
	{
		parent::__construct();
        $this->_t2_body_len = 0;
        $this->_sigVer      = 0;
        $this->_cmd         = 2;
    }

    /**
     * @param byte[] $code
     * $param byte[] $key
     * @return byte[]
     */
    public function get_tlv_2($code, $key)
    {
        $this->_t2_body_len = (strlen($code) + 6) + strlen($key);
        $body               = new Buffer($this->_t2_body_len);
        $p                  = 0;
        $body->writeInt16BE($this->_sigVer, $p);
        $p += 2;
        $body->writeInt16BE(strlen($code), $p);
        $p += 2;
        $body->write($code, $p);
        $p += strlen($code);
        $body->writeInt16BE(strlen($key), $p);
        $p += 2;
        $body->write($key, $p);
        $p += strlen($key);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t2_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}
