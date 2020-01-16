<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t187 extends Tlv_t
{
    protected $_t187_body_len = 0;

    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 391;
    }

    /**
     * hex
     * F8 FF 12 23 6E 0D AF 24 97 CE 7E D6 A0 7B DD 68
     *
     * @param $mac
     * @return mixed
     */
    public function get_tlv_187($mac)
    {
        $arg_len = 16;
        if ($mac != null) {
            $arg_len = strlen($mac);
        }
        $this->_t187_body_len = $arg_len;
        $body                 = new Buffer($this->_t187_body_len);
        $body->write($mac, 0, $arg_len);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t187_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}

