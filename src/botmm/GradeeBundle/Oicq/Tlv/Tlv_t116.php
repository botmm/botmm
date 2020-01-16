<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t116 extends Tlv_t
{
    /** @var int _t116_body_len */
    protected $_t116_body_len;
    /** @var int _ver */
    protected $_ver;

    public function __construct()
	{
		parent::__construct();
        $this->_t116_body_len = 0;
        $this->_ver           = 0;
        $this->_cmd           = 278;
    }

    /**
     * @param int    $bitmap
     * @param int    $get_sig ,
     * @param long[] appid 1600000226L 1600000749L
     * @return byte[]
     */
    public function get_tlv_116($bitmap, $get_sig, $appid)
    {
        if ($appid == null) {
            $appid = [];
        }
        $this -> _t116_body_len = (count($appid) * 4) + 10;
        $p = 0;
        $body = new Buffer($this->_t116_body_len);
        $body->writeInt8($this->_ver, $p);
        $p += 1;
        $body->writeInt32BE($bitmap, $p);
        $p += 4;
        $body->writeInt32BE($get_sig, $p);
        $p += 4;
        $body->writeInt8(count($appid), $p);
        $p++;
        for ($j = 0 ; $j < count($appid); $j++ ) {
            $body->writeInt32BE($appid[$j], $p);
            $p += 4;
        }
        $this->fill_head($this -> _cmd);
        $this->fill_body($body, $p);
        $this->set_length();
        return $this->get_buf();
    }
}
