<?php


namespace botmm\BufferBundle\Buffer;


class StreamInputBuffer
{

    /**
     * @var Buffer
     */
    protected $buffer;

    protected $length;

    protected $offset = 0;

    public function __construct($buffer = null)
    {
        if ($buffer) {
            $this->buffer = $buffer;
            $this->length = $this->buffer->getBufferCapacity();
        }
    }

    public static function from($bin)
    {
        $stream         = new StreamInputBuffer();
        $stream->length = strlen($bin);
        $stream->buffer = Buffer::from($bin);
        return $stream;

    }

    public function read($length = null)
    {
        if ($length === null) {
            $bytes = $this->buffer->read($this->offset, $this->length - $this->offset);
        } else {
            $bytes = $this->buffer->read($this->offset, $length);

        }
        $this->offset += $length;
        return $bytes;
    }

    public function readHex($length, $space = true)
    {
        $bytes        = $this->buffer->readHex($this->offset, $length, $space);
        $this->offset += $length;
        return $bytes;
    }

    public function readInt8()
    {
        $bytes        = $this->buffer->readInt8($this->offset);
        $this->offset += 1;
        return $bytes;
    }

    public function readInt16BE()
    {
        $bytes        = $this->buffer->readInt16BE($this->offset);
        $this->offset += 2;
        return $bytes;
    }

    public function readInt16LE()
    {
        $bytes        = $this->buffer->readInt16LE($this->offset);
        $this->offset += 2;
        return $bytes;
    }

    public function readInt32BE()
    {
        $bytes        = $this->buffer->readInt32BE($this->offset);
        $this->offset += 4;
        return $bytes;
    }

    public function readInt32LE()
    {
        $bytes        = $this->buffer->readInt32LE($this->offset);
        $this->offset += 4;
        return $bytes;
    }


    public function readInt64BE()
    {
        $bytes        = $this->buffer->readInt64BE($this->offset);
        $this->offset += 8;
        return $bytes;
    }

    public function readInt64LE()
    {
        $bytes        = $this->buffer->readInt64LE($this->offset);
        $this->offset += 8;
        return $bytes;
    }

    public function readFloatBE()
    {
        $bytes        = $this->buffer->readFloatBE($this->offset);
        $this->offset += 4;
        return $bytes;
    }

    public function readFloatLE()
    {
        $bytes        = $this->buffer->readFloatLE($this->offset);
        $this->offset += 4;
        return $bytes;
    }

    public function readDoubleBE()
    {
        $bytes        = $this->buffer->readDoubleBE($this->offset);
        $this->offset += 8;
        return $bytes;
    }

    public function readDoubleLE()
    {
        $bytes        = $this->buffer->readDoubleLE($this->offset);
        $this->offset += 8;
        return $bytes;
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

    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
}