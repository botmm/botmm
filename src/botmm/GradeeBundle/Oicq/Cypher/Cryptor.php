<?php


namespace botmm\GradeeBundle\Oicq\Cypher;


use botmm\BufferBundle\Buffer\Buffer;

class Cryptor
{

    public static function decrypt($paramArrayOfByte1, $paramInt1, $paramInt2, $paramArrayOfByte2)
    {
        if (($paramArrayOfByte1 == null) || ($paramArrayOfByte2 == null)) {
            return null;
        } elseif ($paramArrayOfByte1 instanceof Buffer) {
            $arrayOfByte1 = $paramArrayOfByte1->read($paramInt1, $paramInt2);
        } else {
            $arrayOfByte1 = substr($paramArrayOfByte1, $paramInt1, $paramInt2);
        }
        return Tea::decrypt($arrayOfByte1, $paramArrayOfByte2);
    }

    public static function encrypt($paramArrayOfByte1, $paramInt1, $paramInt2, $paramArrayOfByte2)
    {
        if (($paramArrayOfByte1 == null) || ($paramArrayOfByte2 == null)) {
            return null;
        } elseif ($paramArrayOfByte1 instanceof Buffer) {
            $arrayOfByte1 = $paramArrayOfByte1->read($paramInt1, $paramInt2);
        } elseif (is_string($paramArrayOfByte1)) {
            $arrayOfByte1 = substr($paramArrayOfByte1, $paramInt1, $paramInt2);
        }
        return Tea::encrypt($arrayOfByte1, $paramArrayOfByte2);
    }
}