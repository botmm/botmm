<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t145 extends Tlv_t
{
    public $_t145_body_len;

    public function __construct()
	{
		parent::__construct();
        $this->_t145_body_len = 0;
        $this->_cmd           = 325;
    }

    public function get_tlv_145($guid)
    {
        $in_len   = 0;
        $guid_len = strlen($guid);
        if ($guid != null) {
            $in_len = 0 + $guid_len;
        }
        $body = new Buffer($in_len);
        if ($in_len > 0) {
            $body->write($guid, 0);
        }
        $this->_t145_body_len = $in_len;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $in_len);
        $this->set_length();
        return $this->get_buf();
    }
}
