<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t147 extends Tlv_t {
    public function __construct()
	{
		parent::__construct();
        $this->_cmd = 327;
    }

private function limit_len($data, $max_len) {
    if ($data == null) {
        return 0;
    }
    if (strlen($data) > $max_len) {
        return $max_len;
    }
    return strlen($data);
}

    public function get_tlv_147($appVerID, $appVer, $appSign) {
        $appVer_len = $this->limit_len($appVer, 32);
        $appSign_len = $this->limit_len($appSign, 32);
        $body = new Buffer(((($appVer_len + 6) + 2) + $appSign_len));
        $pos = 0;
        $body->writeInt32BE($appVerID, $pos);
        $pos += 4;
        $body->writeInt16BE($appVer_len, $pos);
        $pos += 2;
        $body->write($appVer, $pos, $appVer_len);
        $pos += $appVer_len;
        $body->writeInt16BE($appSign_len, $pos);
        $pos += 2;
        $body->write($appSign, $pos, $appSign_len);
        $pos += $appSign_len;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $pos);
        $this->set_length();
        return $this->get_buf();
    }
}
