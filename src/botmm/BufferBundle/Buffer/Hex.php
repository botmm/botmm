<?php


namespace botmm\BufferBundle\Buffer;


class Hex
{


    /**
     * @param $string
     * @return string
     */
    public static function HexStringToBin($string)
    {
        $bytes = preg_replace('/\s/', '', $string);
        $bytes = hex2bin($bytes);
        return $bytes;
    }

    public static function BinToHexString($string, $withSpace = true) {
        $hexString = bin2hex($string);
        if($withSpace) {
            preg_match_all('/[\da-f]{2}/', $hexString, $mathes);
            $hexString = implode(' ', $mathes[0]);
        }
        return $hexString;
    }
}