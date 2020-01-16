<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t119 extends Tlv_t
{
    protected $_t119_body_len;

    public function __construct()
	{
		parent::__construct();
        $this->_cmd           = 0x119;
    }

    public function verify()
    {
        return true;
    }
}
