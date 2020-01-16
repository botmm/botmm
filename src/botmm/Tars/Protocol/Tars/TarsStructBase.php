<?php


namespace botmm\Tars\Protocol\Tars;


abstract class TarsStructBase implements \Serializable
{

    public static $BYTE         = 0;
    public static $SHORT        = 1;
    public static $INT          = 2;
    public static $LONG         = 3;
    public static $FLOAT        = 4;
    public static $DOUBLE       = 5;
    public static $STRING1      = 6;
    public static $STRING4      = 7;
    public static $MAP          = 8;
    public static $LIST         = 9;
    public static $STRUCT_BEGIN = 10;
    public static $STRUCT_END   = 11;
    public static $ZERO_TAG     = 12;
    public static $SIMPLE_LIST  = 13;

    public static $MAX_STRING_LENGTH = 100 * 1024 * 1024;

    public abstract function writeTo(TarsOutputStream $os);

    public abstract function readFrom(TarsInputStream $is);

    public function display($sb, $level): void
    {
    }

    public function displaySimple($sb, $level): void
    {
    }

    public function newInit()
    {
        return null;
    }

    public function recyle()
    {

    }

    public function containField(string $name)
    {
        return false;
    }

    public function getFieldByName(string $name)
    {
        return null;
    }

    public function setFieldByName(string $name, object $value)
    {
    }

    public function toByteArray(string $encoding = null)
    {
        $os = new TarsOutputStream();
        if($encoding != null){
            $os->setServerEncoding($encoding);
        }
        $this->writeTo($os);
        return $os->toByteArray();
    }

    public function __toString()
    {

    }
}
