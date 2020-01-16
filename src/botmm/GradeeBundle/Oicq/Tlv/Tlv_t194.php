<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\GradeeBundle\Oicq\Tools\ServerTools;

/**
 * Class Tlv_t194
 * md5(IMSI)
 * 登录时此信息可选

 *
*@package botmm\GradeeBundle\Oicq\Tlv
 */
class Tlv_t194 extends Tlv_t
{

    /** @var int _t194_body_len */
    protected $_t194_body_len;

    public function __construct()
    {
        parent::__construct();
        $this->_t194_body_len = 16;
        $this->_cmd           = 0x194;
    }


    /**
     * @param byte[]|string   $imsi 5f 64 aa b8 ed a2 e7 73 ca 1d 79 5d e6 19 19 68
     */
    public function get_tlv_194($imsi)
    {
        $body = new Buffer($this->_t194_body_len);
        $p    = 0;
        $body->write($imsi, $p, 16);
        $p += 16;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $p);
        $this->set_length();
        return $this->get_buf();
    }
}
