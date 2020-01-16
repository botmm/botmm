<?php

namespace botmm\GradeeBundle\Oicq\Cypher;


class MD5
{
    public static function toMD5Byte($string)
    {
        return md5($string, true);
    }
}