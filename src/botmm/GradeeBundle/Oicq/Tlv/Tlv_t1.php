<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\GradeeBundle\Oicq\Tools\ServerTools;

class Tlv_t1 extends Tlv_t
{

    /** @var byte[] IP_KEY */
    protected $IP_KEY;
    /** @var int _ip_len */
    protected $_ip_len;
    /** @var int _ip_pos */
    protected $_ip_pos;
    /** @var int _ip_ver */
    protected $_ip_ver;
    /** @var int _t1_body_len */
    protected $_t1_body_len;

    public function __construct()
    {
        parent::__construct();
        $this->_ip_len      = 4;
        $this->_ip_pos      = 14;
        $this->_ip_ver      = 1;
        $this->_t1_body_len = 20;
        $this->IP_KEY       = new Buffer(2);
        $this->_cmd         = 1;
    }

    public function verify()
    {
        if ($this->_body_len < 20) {
            return false;
        }
        return true;
    }

    public function get_ip()
    {
        return $this->_buf->read($this->_ip_pos, $this->_ip_len);
    }

    /**
     * @param long   $uin
     * @param byte[] $client_ip
     * @return byte[]
     */
    public function get_tlv_1($uin, $client_ip)
    {
        $body = new Buffer($this->_t1_body_len);
        $p    = 0;
        $body->writeInt16BE($this->_ip_ver, $p);
        $p += 2;
        $body->writeInt32BE(mt_rand(), $p);
        $p += 4;
        $body->writeInt32BE($uin, $p);
        $p += 4;
        $body->writeInt32BE(ServerTools::get_server_cur_time(), $p);
        $p += 4;
        $body->write($client_ip, $p, 4); //4bytes
        $p += 4;
        $body->writeInt16BE(0, $p);
        $p += 2;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $p);
        $this->set_length();
        return $this->get_buf();
    }
}
