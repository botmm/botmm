<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t107 extends Tlv_t
{
    /** @var int _t107_body_len; */
    protected $_t107_body_len;

    public function __construct()
	{
		parent::__construct();
        $this->_t107_body_len = 6;
        $this->_cmd           = 263;
    }

    /**
     * @param int $pic_type
     * @param int $cap_type
     * @param int $pic_size
     * @param int $ret_type
     * @return mixed
     */
    public function get_tlv_107($pic_type, $cap_type, $pic_size, $ret_type)
    {
        $body = new Buffer($this->_t107_body_len);
        $p = 0;
        $body->writeInt16BE($pic_type, $p);
        $p += 2;
        $body->writeInt8($cap_type, $p);
        $p++;
        $body->writeInt16BE($pic_size, $p);
        $p += 2;
        $body->writeInt8($ret_type, $p);
        $p++;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t107_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}
