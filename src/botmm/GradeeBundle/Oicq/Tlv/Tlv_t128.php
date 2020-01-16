<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t128 extends Tlv_t
{
    protected $_t128_body_len;

    public function __construct()
    {
        parent::__construct();
        $this->_t128_body_len = 0;
        $this->_cmd           = 296;
    }

    /**
     * @param byte[] $data
     * @param int    $max_len
     * @return int|string
     */
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
     * @param int            $newins     00
     * @param int            $readguid   01
     * @param int            $guidchg    01|00
     * @param int            $flag       01 00 02 00
     * @param  byte[]|string $devicetype 设备名
     * @param  byte[]|string $guid
     * @param byte[]|string  $deviceName
     * @return
     * @internal param $byte $
     */
    public function get_tlv_128($newins, $readguid, $guidchg, $flag, $devicetype, $guid, $deviceName)
    {
        $devicetype_len       = $this->limit_len($devicetype, 32);
        $guid_len             = $this->limit_len($guid, 16);
        $deviceName_len       = $this->limit_len($deviceName, 16);
        $this->_t128_body_len = ((($devicetype_len + 11) + 2) + $guid_len) + 2 + $deviceName_len;
        $body                 = new Buffer($this->_t128_body_len);
        $pos                  = 0;
        $body->writeInt16BE(0, $pos);
        $pos += 2;
        $body->writeInt8($newins, $pos);
        $pos++;
        $body->writeInt8($readguid, $pos);
        $pos++;
        $body->writeInt8($guidchg, $pos);
        $pos++;
        $body->writeInt32BE($flag, $pos);
        $pos += 4;
        $body->writeInt16BE($devicetype_len, $pos);
        $pos += 2;
        $body->write($devicetype, $pos, $devicetype_len);
        $pos += $devicetype_len;
        $body->writeInt16BE($guid_len, $pos);
        $pos += 2;
        $body->write($guid, $pos, $guid_len);
        $pos += $guid_len;
        $body->writeInt16BE($deviceName_len, $pos);
        $pos += 2;
        $body->write($deviceName, $pos, $deviceName_len);
        $pos += $deviceName_len;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t128_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}