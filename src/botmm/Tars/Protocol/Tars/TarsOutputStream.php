<?php


namespace botmm\Tars\Protocol\Tars;


use botmm\BufferBundle\Buffer\StreamOutputBuffer;
use botmm\Tars\Protocol\Tars\Exception\TarsEncodeException;
use Ds\Map;
use Iterator;

class TarsOutputStream
{

    /**
     * @var StreamOutputBuffer
     */
    private $bs;


    public function __construct($bs = null)
    {
        if ($bs == null) {
            $this->bs = new StreamOutputBuffer();
        } else {
            $this->bs = $bs;
        }
    }

    public function getByteBuffer()
    {
        return $this->bs->getBytes();
    }

    public function writeHead(int $type, int $tag)
    {
        if ($tag < 15) {
            $b = (($tag << 4) | $type);
            //$this->bs.put($b);
            $this->bs->writeInt8($b);
        } else {
            if ($tag < 256) {
                $b = ((0xf << 4) | $type);
                //$this->bs.put($b);
                //$this->bs.put($tag);
                $this->bs->writeInt8($b);
                $this->bs->writeInt8($tag);
            } else {
                throw new TarsEncodeException("tag is too large: $tag");
            }
        }
    }

    public function writeBoolean(bool $b, int $tag)
    {
        $by = ($b ? 0x01 : 0);
        $this->writeByte($by, $tag);
    }

    public function writeByte($b, int $tag)
    {
        //$this->reserve(3);
        if ($b == 0) {
            $this->writeHead(TarsStructBase::$ZERO_TAG, $tag);
        } else {
            $this->writeHead(TarsStructBase::$BYTE, $tag);
            //$this->bs.put($b);
            $this->bs->writeInt8($b);
        }
    }

    public function writeShort(int $n, int $tag)
    {
        //$this->reserve(4);
        if ($n >= -128 && $n <= 127) {
            $this->writeByte($n, $tag);
        } else {
            $this->writeHead(TarsStructBase::$SHORT, $tag);
            //$this->bs.putShort($n);
            $this->bs->writeInt16BE($n);
        }
    }

    public function writeInt(int $n, int $tag)
    {
        //$this->reserve(6);
        if ($n >= -32768 && $n <= 32767) {
            $this->writeShort($n, $tag);
        } else {
            $this->writeHead(TarsStructBase::$INT, $tag);
            //$this->bs . putInt($n);
            $this->bs->writeInt32BE($n);
        }
    }

    public function writeLong(int $n, int $tag)
    {
        //$this->reserve(10);
        if ($n >= -0x80000000 && $n <= 0x7fffffff) {
            $this->writeInt($n, $tag);
        } else {
            $this->writeHead(TarsStructBase::$LONG, $tag);
            //$this->bs . putLong($n);
            $this->bs->writeInt64BE($n);

        }
    }

    public function writeFloat(float $n, int $tag)
    {
        //reserve(6);
        $this->writeHead(TarsStructBase::$FLOAT, $tag);
        //$this->bs . putFloat($n);
        $this->bs->writeFloatBE($n);
    }

    public function writeDouble(float $n, int $tag)
    {
        //reserve(10);
        $this->writeHead(TarsStructBase::$DOUBLE, $tag);
        //$this->bs . putDouble($n);
        $this->bs->writeDoubleBE($n);
    }

    public function writeHexString(String $s, int $tag)
    {
        $by = hex2bin($s);
        //reserve(10 + by.length);
        if (strlen($by) > 255) {
            $this->writeHead(TarsStructBase::$STRING4, $tag);
            $this->bs->writeInt32BE(strlen($by));
            $this->bs->write($by);
        } else {
            $this->writeHead(TarsStructBase::$STRING1, $tag);
            $this->bs->writeInt8(strlen($by));
            $this->bs->write($by);
        }
    }

    public function writeByteString(String $s, int $tag)
    {
        //reserve(10 + s . length());
        $by = $s;
        if (strlen($by) > 255) {
            $this->writeHead(TarsStructBase::$STRING4, $tag);
            $this->bs->writeInt32BE(strlen($by));
            $this->bs->write($by);
        } else {
            $this->writeHead(TarsStructBase::$STRING1, $tag);
            $this->bs->writeInt8(strlen($by));
            $this->bs->write($by);
        }
    }

    public function writeString(string $s, int $tag, $encode = "UTF-8")
    {
        $by = mb_convert_encoding($s, $this->sServerEncoding, ["auto", $encode]);
        //reserve(10 + by . length);
        if (strlen($by) > 255) {
            $this->writeHead(TarsStructBase::$STRING4, $tag);
            $this->bs->writeInt32BE(strlen($by));
            $this->bs->write($by);
        } else {
            $this->writeHead(TarsStructBase::$STRING1, $tag);
            $this->bs->writeInt8(strlen($by));
            $this->bs->write($by);
        }
    }

    public function writeMap(Map $m, int $tag)
    {
        //reserve(8);
        $this->writeHead(TarsStructBase::$MAP, $tag);
        $this->writeInt($m == null ? 0 : $m->count(), 0);
        if ($m != null) {
            foreach ($m as $mKey => $mValue) {
                $this->write($mKey, 0);
                $this->write($mValue, 1);
            }
        }
    }

    /**
     * @param bool[] $l
     * @param int    $tag
     */
    public function writeBooleanArray(array $l, int $tag)
    {
        //reserve(8);
        $this->writeHead(TarsStructBase::$LIST, $tag);
        $this->writeInt(count($l), 0);
        foreach ($l as $e) {
            $this->writeBoolean($e, 0);
        }
    }

    /**
     * @param int[]|byte[] $l
     * @param int    $tag
     */
    public function writeByteArray($l, int $tag)
    {
        //reserve(8 + l . length);
        $this->writeHead(TarsStructBase::$SIMPLE_LIST, $tag);
        $this->writeHead(TarsStructBase::$BYTE, 0);
        $this->writeInt(count($l), 0);
        //bs . put(l);
        foreach ($l as $e) {
            $this->bs->writeInt8($e);
        }
    }

    /**
     * @param short[]|int[] $l
     * @param int           $tag
     */
    public function writeShortArray($l, int $tag)
    {
        //reserve(8);
        $this->writeHead(TarsStructBase::$LIST, $tag);
        $this->writeInt(count($l), 0);
        foreach ($l as $e) {
            $this->writeShort($e, 0);
        }
    }

    public function writeIntArray($l, int $tag)
    {
        //reserve(8);
        $this->writeHead(TarsStructBase::$LIST, $tag);
        $this->writeInt(count($l), 0);
        foreach ($l as $e) {
            $this->writeInt($e, 0);
        }
    }

    /**
     * @param     $l
     * @param int $tag
     */
    public function writeLongArray($l, int $tag)
    {
        //reserve(8);
        $this->writeHead(TarsStructBase::$LIST, $tag);
        $this->writeInt(count($l), 0);
        foreach ($l as $e) {
            $this->writeLong($e, 0);
        }
    }

    public function writeFloatArray($l, int $tag)
    {
        //reserve(8);
        $this->writeHead(TarsStructBase::$LIST, $tag);
        $this->writeInt(count($l), 0);
        foreach ($l as $e) {
            $this->writeFloat($e, 0);
        }
    }

    public function writeDoubleArray($l, int $tag)
    {
        //reserve(8);
        $this->writeHead(TarsStructBase::$LIST, $tag);
        $this->writeInt(count($l), 0);
        foreach ($l as $e) {
            $this->writeDouble($e, 0);
        }
    }

    public function writeByteStringArray($l, int $tag)
    {
        $this->writeHead(TarsStructBase::$LIST, $tag);
        $this->writeInt(count($l), 0);
        foreach ($l as $e) {
            $this->writeByteString($e, 0);
        }
    }

    public function writeStringArray($l, int $tag, $encode = "UTF-8")
    {
        $this->writeHead(TarsStructBase::$LIST, $tag);
        $this->writeInt(count($l), 0);
        foreach ($l as $e) {
            $this->writeString($e, 0, $encode);
        }
    }

    public function writeArray($l, int $tag)
    {
        //reserve(8);
        $this->writeHead(TarsStructBase::$LIST, $tag);
        $this->writeInt(count($l), 0);
        foreach ($l as $e) {
            $this->write($e, $tag);
        }
    }

    public function writeTarsStruct(TarsStructBase $o, int $tag)
    {
        //reserve(2);
        $this->writeHead(TarsStructBase::$STRUCT_BEGIN, $tag);
        $o->writeTo($this);
        //reserve(2);
        $this->writeHead(TarsStructBase::$STRUCT_END, 0);
    }

    /**
     * @param int|mixed|string|object $o
     * @param int                     $tag
     */
    public function write($o, int $tag)
    {
        if (is_bool($o)) {
            $this->writeBoolean($o, $tag);
        } elseif (is_integer($o)) {
            $this->writeLong($o, $tag);
        } elseif (is_float($o)) {
            $this->writeDouble($o, $tag);
        //} elseif (is_double($o)) {
        //    $this->writeDouble($o, $tag);
        } elseif (is_string($o)) {
            $this->writeString($o, $tag);
        } elseif ($o instanceof Map) {
            $this->writeMap($o, $tag);
        } elseif ($o instanceof TarsStructBase) {
            $this->writeTarsStruct($o, $tag);
        } elseif (is_array($o)) {
            $this->writeArray($o, $tag);
        } elseif ($o instanceof Iterator) {
            $this->writeArray($o, $tag);
        } else {
            TarsOutputStreamExt::write($o, $tag, $this);
        }
    }

    protected $sServerEncoding = "UTF-8";

    public function setServerEncoding($se)
    {
        $this->sServerEncoding = $se;
        return 0;
    }
}