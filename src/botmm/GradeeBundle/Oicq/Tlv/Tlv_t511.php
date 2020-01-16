<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamOutputBuffer;

class Tlv_t511 extends Tlv_t
{

    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 0x511;
    }


    /**
     */
    public function get_tlv_511($list)
    {
        $body = new StreamOutputBuffer(new Buffer());

        $body->writeInt16BE(count($list));
        for ($index = 0; $index < count($list); $index++) {
            //$string = $list[$index];
            //$n2     = $string[0x28];
            //$n3     = $string[0x29];
            //if ($n2 == 0 && $n3 > 0) {
            //    $n4 = substr($string, $n2 + 1, $n3);
            //    $n2 = (0x100000 & $n4) > 0 ? 1 : 0;
            //    $n4 = ($n4 & 0x8000000) > 0 ? 1 : 0;
            //    if ($n4) {
            //        $by2 = $n2 | 2;
            //    } else {
            //        $by2 = $n2;
            //    }
            //    $string = substr($string, $n3 + 1);
            //} else {
            //    $by2 = 1;
            //}
            $string = $list[$index];
            $body->writeInt8(1);
            $body->writeInt16BE(strlen($string));
            $body->write($string);
        }

        $this->fill_head($this->_cmd);
        $this->fill_body($body->getBytes(), $body->getLength());
        $this->set_length();
        return $this->get_buf();
    }
}