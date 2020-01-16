<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t141 extends Tlv_t {
    protected $_version;

    public function __construct()
	{
		parent::__construct();
        $this->_version = 1;
        $this->_cmd = 321;
    }

    /**
     * @param byte[]|string $operator_name
     * @param int $network_type
     * @param byte[]|string $apn
     * @return mixed
     */
    public function get_tlv_141($operator_name, $network_type, $apn) {
        $operator_name_len = strlen($operator_name);
        $apn_len = strlen($apn);
        $_t141_body_len = ((($operator_name_len + 4) + 2) + 2) + $apn_len;
        $body = new Buffer($_t141_body_len);
        $p = 0;
        $body->writeInt16BE($this->_version, $p);
        $p += 2;
        $body->writeInt16BE($operator_name_len, $p);
        $p += 2;
        $body->write($operator_name, $p, $operator_name_len);
        $p += $operator_name_len;
        $body->writeInt16BE($network_type, $p);
        $p += 2;
        $body->writeInt16BE($apn_len, $p);
        $p += 2;
        $body->write($apn, $p, $apn_len);
        $p += $apn_len;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $p);
        $this->set_length();
        return $this->get_buf();
    }
}
