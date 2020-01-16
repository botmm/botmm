<?php


namespace botmm\Tars\Protocol\Tars;

use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamInputBuffer;
use botmm\Tars\Protocol\Tars\Exception\TarsDecodeException;
use Ds\Map;
use Exception;
use Reflection;
use ReflectionClass;

class TarsInputStream
{

    /**
     * @var StreamInputBuffer
     */
    private $bs; // 缓冲区

    public function __construct($bs)
    {
        if (is_string($bs)) {
            $this->bs = new StreamInputBuffer(new Buffer($bs));
        } elseif ($bs instanceof Buffer) {
            $this->bs = new StreamInputBuffer($bs);
        } else {
            $this->bs = $bs;
        }
    }

    /**
     * @param $bs
     * @return TarsInputStream
     */
    public static function fromString($bs)
    {
        return new self(Buffer::from($bs));
    }

    /**
     * @param $bs
     * @return TarsInputStream
     */
    public static function fromHexString($bs)
    {
        $bs = hex2bin($bs);
        return new self(Buffer::from($bs));
    }

    /**
     * @param $bs
     * @return TarsInputStream
     */
    public static function fromBuffer(Buffer $bs)
    {
        return new self($bs);
    }

    public function readHead(HeadData $hd): int
    {
        $b        = $this->bs->readInt8();
        $hd->type = ($b & 0xf);
        $hd->tag  = (($b & (0xf << 4)) >> 4);
        if ($hd->tag == 0xf) {
            $hd->tag = $this->bs->readInt8() & 0x00ff;
            return 2;
        }
        return 1;
    }

    private function peakHead(HeadData $hd)
    {
        //return $this->readHead($hd, bs.duplicate());
        return (new self(clone $this->bs))->readHead($hd);
    }

    private function skip(int $len)
    {
        $this->bs->setOffset($this->bs->getOffset() + $len);
    }

    public function skipToTag(int $tag): bool
    {
        try {
            $hd = new HeadData();
            while (true) {
                $len = $this->peakHead($hd);
                if ($hd->type == TarsStructBase::$STRUCT_END) {
                    return false;
                }
                if ($tag <= $hd->tag) {
                    return $tag == $hd->tag;
                }
                $this->skip($len);
                $this->skipField($hd->type);
            }
        } catch (TarsDecodeException $e) {
        }
        return false;
    }

    public function skipToStructEnd()
    {
        $hd = new HeadData();
        do {
            $this->readHead($hd);
            $this->skipField($hd->type);
        } while ($hd->type != TarsStructBase::$STRUCT_END);
    }

    /**
     * @param byte|null $type
     */
    private function skipField($type = null)
    {
        if ($type == null) {
            $hd = new HeadData();
            $this->readHead($hd);
            $type = $hd->type;
        }
        switch ($type) {
            case TarsStructBase::$BYTE:
                $this->skip(1);
                break;
            case TarsStructBase::$SHORT:
                $this->skip(2);
                break;
            case TarsStructBase::$INT:
                $this->skip(4);
                break;
            case TarsStructBase::$LONG:
                $this->skip(8);
                break;
            case TarsStructBase::$FLOAT:
                $this->skip(4);
                break;
            case TarsStructBase::$DOUBLE:
                $this->skip(8);
                break;
            case TarsStructBase::$STRING1:
                $len = $this->bs->readInt8();
                if ($len < 0) {
                    $len += 256;
                }
                $this->skip($len);
                break;
            case TarsStructBase::$STRING4:
                $this->skip($this->bs->readInt32BE());
                break;
            case TarsStructBase::$MAP:
                $size = $this->readInt(0, 0, true);
                for ($i = 0; $i < $size * 2; ++$i) {
                    $this->skipField();
                }
                break;
            case TarsStructBase::$LIST:
                $size = $this->readInt(0, 0, true);
                for ($i = 0; $i < $size; ++$i) {
                    $this->skipField();
                }
                break;
            case TarsStructBase::$SIMPLE_LIST:
                $hd = new HeadData();
                $this->readHead($hd);
                if ($hd->type != TarsStructBase::$BYTE) {
                    throw new TarsDecodeException("skipField with invalid type, type value: {$type}, {$hd->type}");
                }
                $size = $this->readInt(0, 0, true);
                $this->skip($size);
                break;
            case TarsStructBase::$STRUCT_BEGIN:
                $this->skipToStructEnd();
                break;
            case TarsStructBase::$STRUCT_END:
            case TarsStructBase::$ZERO_TAG:
                break;
            default:
                throw new TarsDecodeException("invalid type.");
        }
    }

    public function readBoolean(/*bool $b, */
        int $tag,
        bool $isRequire
    ): bool {
        $c = $this->readByte($tag, $isRequire);
        return $c != 0;
    }

    /**
     * @param int|string $c
     * @param int        $tag
     * @param bool       $isRequire
     * @return int
     */
    public function readByte(int $tag, bool $isRequire, bool $sign = true)/*: byte*/
    {
        $c = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$ZERO_TAG:
                    $c = 0x0;
                    break;
                case TarsStructBase::$BYTE:
                    $c = $this->bs->readInt8();
                    if ($sign && $c > 0x7f) {
                        $c -= 0x100;
                    }
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $c;
    }

    /**
     * @param int  $tag
     * @param bool $isRequire
     * @param bool $sign
     * @return short|int
     * @internal param short $n
     */
    public function readShort(int $tag, bool $isRequire, bool $sign = true)/*:short*/
    {
        $n = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$ZERO_TAG:
                    $n = 0;
                    break;
                case TarsStructBase::$BYTE:
                    $n = $this->bs->readInt8();
                    if ($sign && $n > 0x7f) {
                        $n -= 0x100;
                    }
                    break;
                case  TarsStructBase::$SHORT:
                    $n = $this->bs->readInt16BE();
                    if ($sign && $n > 0x7fff) {
                        $n -= 0x10000;
                    }
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $n;
    }

    /**
     * @param int  $tag
     * @param bool $isRequire
     * @param bool $sign
     * @return int|null
     */
    public function readInt(int $tag, bool $isRequire, bool $sign = true)
    {
        $n = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$ZERO_TAG:
                    $n = 0;
                    break;
                case TarsStructBase::$BYTE:
                    $n = $this->bs->readInt8();
                    if ($sign && $n > 0x7f) {
                        $n -= 0x100;
                    }
                    break;
                case TarsStructBase::$SHORT:
                    $n = $this->bs->readInt16BE();
                    if ($sign && $n > 0x7fff) {
                        $n -= 0x10000;
                    }
                    break;
                case TarsStructBase::$INT:
                    $n = $this->bs->readInt32BE();
                    if ($sign && $n > 0x7fffffff) {
                        $n -= 0x100000000;
                    }
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $n;
    }

    /**
     * @param long $n
     * @param int  $tag
     * @param bool $isRequire
     * @return long|int|string
     */
    public function readLong(int $tag, bool $isRequire, $sign = true)/*:long*/
    {
        $n = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$ZERO_TAG:
                    $n = 0;
                    break;
                case TarsStructBase::$BYTE:
                    $n = $this->bs->readInt8();
                    if ($sign && $n > 0x7f) {
                        $n -= 0x100;
                    }
                    break;
                case TarsStructBase::$SHORT:
                    $n = $this->bs->readInt16BE();
                    if ($sign && $n > 0x7fff) {
                        $n -= 0x10000;
                    }
                    break;
                case TarsStructBase::$INT:
                    $n = $this->bs->readInt32BE();
                    if ($sign && $n > 0x7fffffff) {
                        $n -= 0x100000000;
                    }
                    break;
                case TarsStructBase::$LONG:
                    $n = $this->bs->readInt64BE();
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $n;
    }

    public function readFloat(/*float $n, */
        int $tag,
        bool $isRequire
    )/*:float*/
    {
        $n = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$ZERO_TAG:
                    $n = 0;
                    break;
                case TarsStructBase::$FLOAT:
                    $n = $this->bs->readFloatBE();
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $n;
    }

    public function readDouble(/*double $n, */
        int $tag,
        bool $isRequire
    )/*:double*/
    {
        $n = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$ZERO_TAG:
                    $n = 0;
                    break;
                case TarsStructBase::$FLOAT:
                    $n = $this->bs->readFloatBE();
                    break;
                case TarsStructBase::$DOUBLE:
                    $n = $this->bs->readDoubleBE();
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $n;
    }

    public function readHexString(int $tag, bool $isRequire): string
    {
        return bin2hex($this->readByteString($tag, $isRequire));
    }

    public function readByteString(int $tag, bool $isRequire): string
    {
        $s = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$STRING1: {
                    $len = $this->bs->readInt8();
                    if ($len < 0) {
                        $len += 256;
                    }
                    $s = $this->bs->read($len);
                }
                    break;
                case TarsStructBase::$STRING4: {
                    $len = $this->bs->readInt32BE();
                    if ($len > TarsStructBase::$MAX_STRING_LENGTH || $len < 0) {
                        throw new TarsDecodeException("String too long: $len");
                    }
                    $s = $this->bs->read($len);
                }
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $s;
    }

    public function readString(/*String $s, */
        int $tag,
        bool $isRequire
    ): string {
        $s = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$STRING1:
                    $len = $this->bs->readInt8();
                    if ($len < 0) {
                        $len += 256;
                    }
                    $ss = $this->bs->read($len);
                    $s  = mb_convert_encoding($ss, "UTF-8", ["UTF-8", $this->sServerEncoding, "auto"]);
                    break;
                case TarsStructBase::$STRING4:
                    $len = $this->bs->readInt32BE();
                    if ($len > TarsStructBase::$MAX_STRING_LENGTH || $len < 0) {
                        throw new TarsDecodeException("String too long: $len");
                    }
                    $ss = $this->bs->read($len);
                    $s  = mb_convert_encoding($ss, ["UTF-8", $this->sServerEncoding, "auto"]);
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $s;
    }

    public function readStringMap(int $tag, bool $isRequire)/*:Map<String, String>*/
    {
        $mr = new Map();
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$MAP: {
                    $size = $this->readInt(0, true);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: $size");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $k = $this->readString(0, true);
                        $v = $this->readString(1, true);
                        $mr->put($k, $v);
                    }
                }
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $mr;
    }

    public function readTypeMap($mt, int $tag, bool $isRequire)
    {
        $mr = new Map();

        $mKey   = null;
        $mValue = null;
        foreach ($mt as $tmpKey => $tmpValue) {
            $mKey   = ucfirst($tmpKey);
            $mValue = ucfirst($tmpValue);
            break;
        }
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$MAP: {
                    $size = $this->readInt(0, true);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: $size");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $k = $this->{"read$mKey"}(0, true);
                        $v = $this->{"read$mValue"}(1, true);
                        $mr->put($k, $v);
                    }
                }
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $mr;
    }

    public function readMap(int $tag, bool $isRequire)
    {
        $mr = new Map();

        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$MAP: {
                    $size = $this->readInt(0, true);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: $size");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $k = $this->read(0, true);
                        $v = $this->read(1, true);
                        $mr->put($k, $v);
                    }
                }
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $mr;
    }

    public function readList(int $tag, bool $isRequire)
    {
        //List $lr = new ArrayList();
        $lr = [];
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, true);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: $size");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $subH = new HeadData();
                        $this->readHead($subH);
                        switch ($subH->type) {
                            case TarsStructBase::$BYTE:
                                $this->skip(1);
                                break;
                            case TarsStructBase::$SHORT:
                                $this->skip(2);
                                break;
                            case TarsStructBase::$INT:
                                $this->skip(4);
                                break;
                            case TarsStructBase::$LONG:
                                $this->skip(8);
                                break;
                            case TarsStructBase::$FLOAT:
                                $this->skip(4);
                                break;
                            case TarsStructBase::$DOUBLE:
                                $this->skip(8);
                                break;
                            case TarsStructBase::$STRING1:
                                $len = $this->bs->readInt8();
                                if ($len < 0) {
                                    $len += 256;
                                }
                                $this->skip($len);
                                break;
                            case TarsStructBase::$STRING4:
                                $this->skip($this->bs->readInt32BE());
                                break;
                            case TarsStructBase::$MAP:
                                break;
                            case TarsStructBase::$LIST:
                                break;
                            case TarsStructBase::$STRUCT_BEGIN:
                                try {
                                    $rf   = new ReflectionClass(TarsStructBase::class);
                                    $cons = $rf->getConstructor();
                                    /** @var TarsStructBase $struct */
                                    $struct = $cons->invoke(null);
                                    $struct->readFrom($this);
                                    $this->skipToStructEnd();
                                    $lr[] = $struct;
                                } catch (Exception $e) {
                                    throw new TarsDecodeException("type mismatch. {$e->getMessage()}");
                                }
                                break;
                            case TarsStructBase::$ZERO_TAG:
                                $lr[] = 0;
                                break;
                            default:
                                throw new TarsDecodeException("type mismatch.");
                        }
                    }
                }
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $lr;
    }

    /**
     * @param int  $tag
     * @param bool $isRequire
     * @return mixed
     */
    public function readBooleanArray(int $tag, bool $isRequire)/*:bool[]*/
    {
        $lr = [];
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, true);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: $size");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $lr[$i] = $this->readBoolean(0, true);
                    }
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $lr;
    }

    /**
     * @param int  $tag
     * @param bool $isRequire
     * @return mixed
     */
    public function readByteArray(int $tag, bool $isRequire)
    {
        $lr = [];
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$SIMPLE_LIST: {
                    $hh = new HeadData();
                    $this->readHead($hh);
                    if ($hh->type != TarsStructBase::$BYTE) {
                        throw new TarsDecodeException("type mismatch, tag: {$tag}, type: {$hd->type}, {$hh->type}");
                    }
                    $size = $this->readInt(0, true);
                    if ($size < 0) {
                        throw new TarsDecodeException("invalid size, tag: {$tag}, type: {$hd->type}, {$hh->type}, size: {$size}");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $lr[] = $this->bs->readInt8();
                    }
                    break;
                }
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, true);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: {$size}");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $lr[] = $this->readByte(0, true);
                    }
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $lr;
    }

    /**
     * @param int  $tag
     * @param bool $isRequire
     * @param bool $sign
     * @return array
     */
    public function readShortArray(int $tag, bool $isRequire, $sign = true)/*:short[] */
    {
        $lr = [];
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: {$size}");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $lr[$i] = $this->readShort(0, true, $sign);
                    }
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $lr;
    }

    /**
     * @param int  $tag
     * @param bool $isRequire
     * @param bool $sign
     * @return mixed
     * @internal param \int[] $l
     */
    public function readIntArray(/*$l, */
        int $tag,
        bool $isRequire,
        $sign = true
    ) {
        $lr = [];
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, true, $sign);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: $size");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $lr[$i] = $this->readInt(0, true, $sign);
                    }
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $lr;
    }

    /**
     * @param int  $tag
     * @param bool $isRequire
     * @param bool $sign
     * @return mixed
     * @internal param long[] $l
     */
    public function readLongArray(/*$l, */
        int $tag,
        bool $isRequire,
        $sign = true
    ) {
        $lr = [];
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, true, $sign);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: $size");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $lr[$i] = $this->readLong(0, true, $sign);
                    }
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $lr;
    }

    /**
     * @param float[] $l
     * @param int     $tag
     * @param bool    $isRequire
     * @return mixed
     */
    public function readFloatArray($l, int $tag, bool $isRequire)
    {
        $lr = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: $size");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $lr[$i] = $this->readFloat(0, true);
                    }
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $lr;
    }

    /**
     * @param int  $tag
     * @param bool $isRequire
     * @return mixed
     */
    public function readDoubleArray(int $tag, bool $isRequire)
    {
        $lr = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: $size");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $lr[$i] = $this->readDouble(0, true);
                    }
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $lr;
    }

    public function readStringArray($tag, $isRequire) {
        $lr = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: $size");
                    }
                    for ($i = 0; $i < $size; ++$i) {
                        $lr[$i] = $this->readString(0, true);
                    }
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $lr;
    }

    /**
     *
     * @param string|array     $mt
     * @param int  $tag
     * @param bool $isRequire
     * @return mixed
     * @internal param $l
     */
    public function readArray($mt, int $tag, bool $isRequire)
    {
        return $this->readArrayImpl($mt, $tag, $isRequire);
    }

    /**
     * @param string|array     $mt define the type
     * @param int  $tag
     * @param bool $isRequire
     * @return null
     */
    private function readArrayImpl($mt, int $tag, bool $isRequire)
    {
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, true);
                    if ($size < 0) {
                        throw new TarsDecodeException("size invalid: $size");
                    }

                    $lr = [];
                    if (is_array($mt)) {
                        $readMethod = "readMap";
                        for ($i = 0; $i < $size; ++$i) {
                            $t      = $this->{$readMethod}($mt, 0, true);
                            $lr[$i] = $t;
                        }
                        return $lr;
                    } elseif (is_string($mt)) {
                        $readMethod = "read" . ucfirst($mt);
                        for ($i = 0; $i < $size; ++$i) {
                            $t      = $this->{$readMethod}(0, true);
                            $lr[$i] = $t;
                        }
                        return $lr;
                    } else {
                        throw new \InvalidArgumentException("read array must be string or array");
                    }
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return null;
    }

    public function directReadTarsStruct(TarsStructBase $o, int $tag, bool $isRequire)
    {
        $ref = $o;
        if ($this->skipToTag($tag)) {
            //try {
            //    $ref = $o.newInit();
            //} catch (Exception $e) {
            //    throw new TarsDecodeException($e->getMessage());
            //}

            $hd = new HeadData();
            $this->readHead($hd);
            if ($hd->type != TarsStructBase::$STRUCT_BEGIN) {
                throw new TarsDecodeException("type mismatch.");
            }
            $ref->readFrom($this);
            $this->skipToStructEnd();
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $ref;
    }

    /**
     * @param string $o class's name, the class extend TarsStructBase
     * @param int    $tag
     * @param bool   $isRequire
     * @return null|ReflectionClass
     */
    public function readTarsStruct(/*TarsStructBase*/
        $o,
        int $tag,
        bool $isRequire
    ) {
        $ref = null;
        if ($this->skipToTag($tag)) {
            try {
                //$ref = $o.getClass().newInstance();
                /** @var TarsStructBase $ref */
                if($o instanceof TarsStructBase) {
                    $ref = $o;
                }else{
                    $ref = new ReflectionClass($o);
                }
            } catch (Exception $e) {
                throw new TarsDecodeException($e->getMessage());
            }

            $hd = new HeadData();
            $this->readHead($hd);
            if ($hd->type != TarsStructBase::$STRUCT_BEGIN) {
                throw new TarsDecodeException("type mismatch.");
            }
            $ref->readFrom($this);
            $this->skipToStructEnd();
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
        return $ref;
    }

    /**
     * @param TarsStructBase[] $o
     * @param int              $tag
     * @param bool             $isRequire
     * @return mixed
     */
    public function readTarsStructArray($o, int $tag, bool $isRequire)
    {
        return $this->readArray($o, $tag, $isRequire);
    }

    public function read($tag, $isRequire)
    {
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->peakHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$BYTE:
                    return $this->readByte($tag, $isRequire);
                    break;
                case TarsStructBase::$SHORT:
                    return $this->readShort($tag, $isRequire);
                    break;
                case TarsStructBase::$INT:
                    return $this->readInt($tag, $isRequire);
                    break;
                case TarsStructBase::$LONG:
                    return $this->readLong($tag, $isRequire);
                    break;
                case TarsStructBase::$FLOAT:
                    return $this->readFloat($tag, $isRequire);
                    break;
                case TarsStructBase::$DOUBLE:
                    return $this->readDouble($tag, $isRequire);
                    break;
                case TarsStructBase::$STRING1:
                    return $this->readString($tag, $isRequire);
                    break;
                case TarsStructBase::$STRING4:
                    return $this->readString($tag, $isRequire);
                    break;
                case TarsStructBase::$MAP:
                    return $this->readMap($tag, $isRequire);
                    break;
                case TarsStructBase::$LIST:
                    return $this->readList($tag, $isRequire);
                    break;
                case TarsStructBase::$STRUCT_BEGIN:
                    try {
                        $rf   = new ReflectionClass(TarsStructBase::class);
                        $cons = $rf->getConstructor();
                        /** @var TarsStructBase $struct */
                        $struct = $cons->invoke(null);
                        $struct->readFrom($this);
                        $this->skipToStructEnd();
                        $lr[] = $struct;
                    } catch (Exception $e) {
                        throw new TarsDecodeException("type mismatch. {$e->getMessage()}");
                    }
                    break;
                case TarsStructBase::$ZERO_TAG:
                    $lr[] = 0;
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else {
            if ($isRequire) {
                throw new TarsDecodeException("require field not exist.");
            }
        }
    }

    protected $sServerEncoding = "GBK";

    public function setServerEncoding(string $se)
    {
        $this->sServerEncoding = $se;
    }

    public function getBs()
    {
        return $this->bs;
    }
}