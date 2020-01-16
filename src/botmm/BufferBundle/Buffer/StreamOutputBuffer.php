<?php


namespace botmm\BufferBundle\Buffer;

class StreamOutputBuffer
{

    /**
     * @var Buffer
     */
    protected $buffer;
    protected $offset = 0;

    public function __construct($buffer = null)
    {
        if ($buffer == null) {
            $this->buffer = new Buffer();
        } else {
            $this->buffer = $buffer;
        }
    }

    protected function checkCapacity($length)
    {
        $capacity = $this->buffer->getBufferCapacity();
        if ($this->offset + $length > $capacity) {
            $length = $length < 32 ? 32 : $length;
            $this->buffer->expand($capacity + $length << 1);
        }
    }

    /**
     * @param string|woolebuffer|StreamOutputBuffer $string
     * @param null                                  $length
     */
    public function write($string, $length = null)
    {
        if (is_string($string)) {
            if ($length === null) {
                $length = strlen($string);
            }
        } elseif ($string instanceof self) {
            $length = $string->getLength();
            $string = $string->getBuffer();
        }
        $this->checkCapacity($length);
        $this->buffer->write($string, $this->offset, $length);
        $this->offset += $length;
    }

    public function writeHex($string, $length = null)
    {
        if ($length == null) {
            $length = strlen(Hex::HexStringToBin($string));
        }
        $this->checkCapacity($length);
        $this->buffer->writeHex($string, $this->offset, $length);
        $this->offset += $length;
    }

    public function writeInt8($value)
    {
        $this->checkCapacity(1);
        $this->buffer->writeInt8($value, $this->offset);
        $this->offset += 1;
    }

    public function writeInt16BE($value)
    {
        $this->checkCapacity(2);
        $this->buffer->writeInt16BE($value, $this->offset);
        $this->offset += 2;
    }

    public function writeInt16LE($value)
    {
        $this->checkCapacity(2);
        $this->buffer->writeInt16LE($value, $this->offset);
        $this->offset += 2;
    }

    public function writeInt32BE($value)
    {
        $this->checkCapacity(4);
        $this->buffer->writeInt32BE($value, $this->offset);
        $this->offset += 4;
    }

    public function writeInt32LE($value)
    {
        $this->checkCapacity(4);
        $this->buffer->writeInt32LE($value, $this->offset);
        $this->offset += 4;
    }


    public function writeInt64BE($value)
    {
        $this->checkCapacity(8);
        $this->buffer->writeInt64BE($value, $this->offset);
        $this->offset += 8;
    }

    public function writeInt64LE($value)
    {
        $this->checkCapacity(8);
        $this->buffer->writeInt64LE($value, $this->offset);
        $this->offset += 8;
    }

    public function writeFloatBE($value)
    {
        $this->checkCapacity(4);
        $this->buffer->writeFloatBE($value, $this->offset);
        $this->offset += 4;
    }

    public function writeFloatLE($value)
    {
        $this->checkCapacity(4);
        $this->buffer->writeFloatLE($value, $this->offset);
        $this->offset += 4;
    }

    public function writeDoubleBE($value)
    {
        $this->checkCapacity(8);
        $this->buffer->writeDoubleBE($value, $this->offset);
        $this->offset += 8;
    }

    public function writeDoubleLE($value)
    {
        $this->checkCapacity(8);
        $this->buffer->writeDoubleLE($value, $this->offset);
        $this->offset += 8;
    }


    public function getBytes()
    {
        return $this->buffer->read(0, $this->offset);
    }

    public function getBuffer()
    {
        return $this->buffer;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * write length
     *
     * @return mixed
     */
    public function getLength()
    {
        return $this->offset;
    }

}