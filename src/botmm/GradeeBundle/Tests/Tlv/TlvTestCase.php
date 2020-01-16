<?php


namespace botmm\GradeeBundle\Tests\Tlv;


use botmm\GradeeBundle\Oicq\Tools\Hex;
use PHPUnit_Framework_TestCase;

class TlvTestCase extends PHPUnit_Framework_TestCase
{

    protected function assertBinEqualsHex($expected, $actual, $message = "")
    {
        $expected = Hex::BinToHexString(hex2bin(preg_replace('/\s/', '', $expected)));
        $expected = $this->to16Enter($expected);
        $actual   = Hex::BinToHexString($actual);
        $actual   = $this->to16Enter($actual);
        $this->assertEquals($expected, $actual, $message);
    }

    private function to16Enter($result)
    {
        return preg_replace('/((?:[\da-f]{2}\s*){16})/', "$1\n", $result);
    }
}