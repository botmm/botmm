<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\GradeeBundle\Oicq\Tools\util;

class Tlv_t100 extends Tlv_t
{
    /** @var int _db_buf_ver */
    protected $_db_buf_ver;
    /** @var int _sso_ver */
    protected $_sso_ver;
    /** @var int _t100_body_len */
    protected $_t100_body_len;

    public function __construct()
    {
        parent::__construct();
        $this->_db_buf_ver    = 1;
        $this->_sso_ver       = util::SSO_VERSION;
        $this->_t100_body_len = 22;
        $this->_cmd           = 256;
    }


    /**
     * @param $appid
     * @param $wxappid
     * @param $client_ver
     * @param $getsig
     * @return mixed
     */
    public function get_tlv_100($appid, $wxappid, $client_ver, $getsig)
    {
        $body = new Buffer($this->_t100_body_len);
        $p    = 0;
        $body->writeInt16BE($this->_db_buf_ver, $p);
        $p += 2;
        $body->writeInt32BE($this->_sso_ver, $p);
        $p += 4;
        $body->writeInt32BE($appid, $p);
        $p += 4;
        $body->writeInt32BE($wxappid, $p);
        $p += 4;
        $body->writeInt32BE($client_ver, $p);
        $p += 4;
        $body->writeInt32BE($getsig, $p);
        $p += 4;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t100_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}
