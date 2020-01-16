<?php


namespace botmm\BufferBundle\Buffer;


use swoole_buffer;

class Buffer
{
    /**
     * @var swoole_buffer
     */
    protected $buffer;

    protected $lengthMap = [
        'n' => 2,
        'N' => 4,
        'v' => 2,
        'V' => 4,
        'c' => 1,
        'C' => 1,
        'f' => 4,
        'd' => 8,
    ];

    public function __construct($size = 128)
    {
        if (!$size) {
            $size = 128;
        }
        $this->buffer = new swoole_buffer($size);
    }

    public static function from($bin) {
        $buffer = new Buffer(strlen($bin));
        $buffer->write($bin, 0, strlen($bin));
        return $buffer;
    }

    protected function insert($format, $value, $offset, $length)
    {
        $bytes = pack($format, $value);
        for ($i = 0; $i < $length; $i++) {
            $this->buffer->write($offset++, $bytes[$i]);
        }
    }

    protected function extract($format, $offset, $length)
    {
        $encoded = $this->buffer->read($offset, $length);
        if ($format == 'N' && PHP_INT_SIZE <= 4) {
            list(, $h, $l) = unpack('n*', $encoded);
            $result = ($l + ($h * 0x010000));
        } elseif ($format == 'V' && PHP_INT_SIZE <= 4) {
            list(, $h, $l) = unpack('v*', $encoded);
            $result = ($h + ($l * 0x010000));
        } else {
            list(, $result) = unpack($format, $encoded);
        }

        return $result;
    }

    public function write($string, $offset, $length = null)
    {
        if ($string instanceof swoole_buffer || $string instanceof Buffer) {
            if ($length === 0) {
                return;
            } elseif ($length === null) {
                throw new \InvalidArgumentException("when write swoole buffer or Buffer itself, must set length");
            }
            {
                $string = $string->read(0, $length);
            }
        } elseif ($length === null) {
            $length = strlen($string);
        }
        $this->insert('a' . $length, $string, $offset, $length);
    }

    public function writeHex($string, $offset, $length = null)
    {
        $this->write(Hex::HexStringToBin($string), $offset, $length);
    }

    public function writeInt8($value, $offset)
    {
        $this->checkForOverSize(0xff, $value);
        $this->insert('C', $value, $offset, 1);
    }

    public function writeInt16BE($value, $offset)
    {
        $this->checkForOverSize(0xffff, $value);
        $this->insert('n', $value, $offset, 2);
    }

    public function writeInt16LE($value, $offset)
    {
        $this->checkForOverSize(0xffff, $value);
        $this->insert('v', $value, $offset, 2);
    }

    public function writeInt32BE($value, $offset)
    {
        $this->checkForOverSize(0xffffffff, $value);
        $this->insert('N', $value, $offset, 4);
    }

    public function writeInt32LE($value, $offset)
    {
        $this->checkForOverSize(0xffffffff, $value);
        $this->insert('V', $value, $offset, 4);
    }

    public function writeInt64BE($value, $offset)
    {
        $this->checkForOverSize(0xffffffffffffffff, $value);
        $bytes = pack('N*', $value >> 32, $value);
        $this->write($bytes, $offset);
    }

    public function writeInt64LE($value, $offset)
    {
        $this->checkForOverSize(0xffffffffffffffff, $value);
        $bytes = pack('V*', $value, $value >> 32);
        $this->write($bytes, $offset);
    }

    public function writeFloatBE($value, $offset)
    {
        if ($this->isBigEndian()) {
            $this->insert('f', $value, $offset, 4);
        } else {
            $bytes = pack('f', $value);
            $bytes = strrev($bytes);
            $this->write($bytes, $offset, 4);
        }
    }

    public function writeFloatLE($value, $offset)
    {
        if ($this->isBigEndian()) {
            $bytes = pack('f', $value);
            $bytes = strrev($bytes);
            $this->write($bytes, $offset, 4);
        } else {
            $this->insert('f', $value, $offset, 4);
        }
    }

    public function writeDoubleBE($value, $offset)
    {
        if ($this->isBigEndian()) {
            $this->insert('d', $value, $offset, 8);
        } else {
            $bytes = pack('d', $value);
            $bytes = strrev($bytes);
            $this->write($bytes, $offset, 8);
        }
    }

    public function writeDoubleLE($value, $offset)
    {
        if ($this->isBigEndian()) {
            $bytes = pack('d', $value);
            $bytes = strrev($bytes);
            $this->write($bytes, $offset, 8);
        } else {
            $this->insert('d', $value, $offset, 8);
        }
    }

    public function read($offset, $length)
    {
        $format = 'a' . $length;
        return $this->extract($format, $offset, $length);
    }

    public function readBuffer($offset, $length)
    {
        $bytes  = $this->read($offset, $length);
        $buffer = new Buffer($length);
        $buffer->write($bytes, 0, $length);
        return $buffer;
    }

    public function readHex($offset, $length, $space = true)
    {
        $bin = $this->read($offset, $length);
        return Hex::BinToHexString($bin, $space);
    }

    public function readInt8($offset)
    {
        return $this->extract('C', $offset, 1);
    }

    public function readInt16BE($offset)
    {
        return $this->extract('n', $offset, 2);
    }

    public function readInt16LE($offset)
    {
        return $this->extract('v', $offset, 2);
    }

    public function readInt32BE($offset)
    {
        return $this->extract('N', $offset, 4);
    }

    public function readInt32LE($offset)
    {
        return $this->extract('V', $offset, 4);
    }

    public function readInt64BE($offset)
    {
        $MSB = $this->extract('N', $offset, 4);
        $LSB = $this->extract('N', $offset + 4, 4);
        return ($MSB << 32) + $LSB;
    }

    public function readInt64LE($offset)
    {
        $LSB = $this->extract('V', $offset, 4);
        $MSB = $this->extract('V', $offset + 4, 4);
        return ($MSB << 32) + $LSB;
    }

    public function readFloatBE($offset)
    {
        if ($this->isBigEndian()) {
            return $this->extract('f', $offset, 4);
        } else {
            $bytes = $this->read($offset, 4);
            $bytes = strrev($bytes);
            list(, $result) = unpack('f', $bytes);
            return $result;
        }
    }

    public function readFloatLE($offset)
    {
        if ($this->isBigEndian()) {
            $bytes = $this->read($offset, 4);
            $bytes = strrev($bytes);
            list(, $result) = unpack('f', $bytes);
            return $result;
        } else {
            return $this->extract('f', $offset, 4);
        }
    }

    public function readDoubleBE($offset)
    {
        if ($this->isBigEndian()) {
            return $this->extract('d', $offset, 8);
        } else {
            $bytes = $this->read($offset, 8);
            $bytes = strrev($bytes);
            list(, $result) = unpack('d', $bytes);
            return $result;
        }
    }

    public function readDoubleLE($offset)
    {
        if ($this->isBigEndian()) {
            $bytes = $this->read($offset, 8);
            $bytes = strrev($bytes);
            list(, $result) = unpack('d', $bytes);
            return $result;
        } else {
            return $this->extract('d', $offset, 8);
        }
    }

    public function getBufferCapacity()
    {
        return $this->buffer->capacity;
    }

    public function expand($size)
    {
        $this->buffer->expand($size);
    }

    private function checkForOverSize($excpected_max, &$actual)
    {
        if (is_string($actual)) {
            $actual = hexdec(bin2hex($actual));
        }
        if ($actual > $excpected_max) {
            $actual &= $excpected_max;
            throw new \InvalidArgumentException(sprintf('%d exceeded limit of %d', $actual, $excpected_max));
        }
    }

    public function isBigEndian()
    {
        static $endianness;

        if (null === $endianness) {
            list(, $result) = unpack('L', pack('V', 1));
            $endianness = $result !== 1;
        }

        return $endianness;
    }

}