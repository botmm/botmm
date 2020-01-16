<?php
namespace botmm\GradeeBundle\Oicq\Tlv;

use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t151 extends Tlv_t {
    public function __construct()
	{
		parent::__construct();
        $this->_cmd = 337;
    }

    public function get_tlv_151($data) {
        $body_len = 0;
        if ($data != null) {
            $body_len = strlen($data);
        }
        $body = new Buffer($body_len);
        if ($body_len > 0) {
            $body ->write($data, 0, $body_len);
        }
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $body_len);
        $this->set_length();
        return $this->get_buf();
    }
}
