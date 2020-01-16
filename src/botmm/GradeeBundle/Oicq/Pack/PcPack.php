<?php


namespace botmm\GradeeBundle\Pack;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamOutputBuffer;

class PcPack
{
    protected $buffer;
    protected $streamOutputBuffer;
    protected $_cmd = 1536;
    protected $_sub_cmd; //08 10

    public function __construct()
    {
        $this->buffer             = new Buffer();
        $this->streamOutputBuffer = new StreamOutputBuffer($this->buffer);
    }


    public function getPack($cmd, $bin, $ext_key, $ext_bin)
    {
        $this->streamOutputBuffer->writeInt8($this->global->pc_ver);
        $this->streamOutputBuffer->writeInt32BE($cmd);
        $this->streamOutputBuffer->writeInt16BE($this->_sub_cmd);
        $this->streamOutputBuffer->write($this->qq_info->qq_user);
        $this->streamOutputBuffer->writeHex("03 07 00 00 00 00 02 00 00 00 00 00 00 00 00");
        if ($ext_bin != null) {
            $this->streamOutputBuffer->writeHex("01 02");
        } else {
            $this->streamOutputBuffer->writeHex("01 01");
        }
        $this->streamOutputBuffer->write($ext_key);
        $this->streamOutputBuffer->writeHex("01 02");
        $this->streamOutputBuffer->writeInt16BE(strlen($ext_bin));
        if ($ext_bin != null) {
            $this->streamOutputBuffer->write($ext_bin);
        } else {
            $this->streamOutputBuffer->writeHex("00 00");
        }
        $this->streamOutputBuffer->write($bin);
        $this->streamOutputBuffer->writeHex("03");

        $bytes  = $this->streamOutputBuffer->getBytes();
        $length = $this->streamOutputBuffer->getOffset();

        $buffer = new Buffer($length + 3);
        $buffer->writeHex("02", 0);
        $buffer->writeInt16BE($length + 3, 1);
        $buffer->write($bytes, 3);
        return $buffer->read(0, $length + 3);
    }

}