<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamOutputBuffer;

class Tlv_t522 extends Tlv_t
{
    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 0x522;
    }

    /**
     * @param $list
     * @return mixed
     */
    public function get_tlv_522($list)
    {
        list($bufferLen, $buffer) = $this->getExtraData($list);
        $body = new StreamOutputBuffer(new Buffer());
        $body->writeInt8(1);
        $body->writeInt8($bufferLen);//最多(20*3=60=0x3c)
        $body->write($buffer, $bufferLen);

        $this->fill_head($this->_cmd);
        $this->fill_body($body->getBytes(), $body->getLength());
        $this->set_length();
        return $this->get_buf();
    }

    private function getExtraData($list)
    {
        $len    = 0;
        $buffer = new Buffer();
        foreach ($list as $index => $loginExtraData) {
            if ($index >= 3) {
                break;
            }
            $buffer->writeInt64BE($loginExtraData['mUin'], 0);
            $buffer->writeInt32BE($loginExtraData['mIp'], 8);
            $buffer->writeInt32BE($loginExtraData['mTime'], 12);
            $buffer->writeInt32BE($loginExtraData['mVersion'], 16);
            $len += 20;
        }
        return [$len, $buffer];

    }
}