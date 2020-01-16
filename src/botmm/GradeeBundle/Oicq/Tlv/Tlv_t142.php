<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t142 extends Tlv_t {
    protected $_t142_body_len;
    protected $_version;

    public function __construct()
	{
		parent::__construct();
    $this->_version = 0;
    $this->_t142_body_len = 0;
    $this->_cmd = 0x142;
    }

    /**
     * @param $id ﻿_apk_id
     * @return mixed
     */
    public function get_tlv_142($id) {
        $id_len = strlen($id);
        $this->_t142_body_len = $id_len + 4;
        $body = new Buffer($this->_t142_body_len);
        $pos = 0;
        $body->writeInt16BE($this->_version, $pos);
        $pos += 2;
        $body->writeInt16BE($id_len, $pos);
        $pos += 2;
        $body->write($id, $pos, $id_len);
        $pos += $id_len;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $pos);
        $this->set_length();
        return $this->get_buf();
    }
}
