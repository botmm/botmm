<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t124 extends Tlv_t
{
    protected $_t124_body_len;

    public function __construct()
    {
        parent::__construct();
        $this->_t124_body_len = 0;
        $this->_cmd           = 292;
    }

    private function limit_len($data, $max_len)
    {
        if ($data == null) {
            return 0;
        }
        if (strlen($data) > $max_len) {
            return $max_len;
        }
        return strlen($data);
    }

    /**
     * @param byte[]|string $ostype
     * @param byte[]|string $osver
     * @param int           $nettype
     * @param byte[]|string $netdetail
     * @param byte[]|string $addr
     * @param byte[]|string $apn
     */
    public function get_tlv_124($ostype, $osver, $nettype, $netdetail, $addr, $apn)
    {
        $ostype_len           = $this->limit_len($ostype, 16);
        $osver_len            = $this->limit_len($osver, 16);
        $netdetail_len        = $this->limit_len($netdetail, 16);
        $addr_len             = $this->limit_len($addr, 32);
        $apn_len              = $this->limit_len($apn, 16);
        $this->_t124_body_len = $ostype_len + 2
            + $osver_len + 2
            + 2
            + $netdetail_len + 2
            + $addr_len + 2
            + $apn_len + 2;
        $body                 = new Buffer($this->_t124_body_len);
        $pos                  = 0;
        $body->writeInt16BE($ostype_len, $pos);
        $pos += 2;
        $body->write($ostype, $pos);
        $pos += $ostype_len;

        $body->writeInt16BE($osver_len, $pos);
        $pos += 2;
        $body->write($osver, $pos, $osver_len);
        $pos += $osver_len;

        $body->writeInt16BE($nettype, $pos);
        $pos += 2;

        $body->writeInt16BE($netdetail_len, $pos);
        $pos += 2;
        $body->write($netdetail, $pos, $netdetail_len);
        $pos += $netdetail_len;

        $body->writeInt16BE($addr_len, $pos);
        $pos += 2;
        $body->write($addr, $pos, $addr_len);
        $pos += $addr_len;

        $body->writeInt16BE($apn_len, $pos);
        $pos += 2;
        $body->write($apn, $pos, $apn_len);
        $pos += $apn_len;

        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t124_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}
