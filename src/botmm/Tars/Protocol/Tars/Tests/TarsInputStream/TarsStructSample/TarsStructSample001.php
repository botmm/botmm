<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsInputStream\TarsStructSample;


use botmm\Tars\Protocol\Tars\TarsInputStream;
use botmm\Tars\Protocol\Tars\TarsOutputStream;
use botmm\Tars\Protocol\Tars\TarsStructBase;

class TarsStructSample001 extends TarsStructBase
{
    public $data1;
    public $data2;

    public function __construct()
    {
    }

    public function writeTo(TarsOutputStream $os)
    {
        $os->writeInt($this->data1, 1);
        $os->writeInt($this->data2, 2);
    }

    public function readFrom(TarsInputStream $is)
    {
        $this->data1 = $is->readInt(1, true);
        $this->data2 = $is->readInt(2, true);
    }


    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }
}