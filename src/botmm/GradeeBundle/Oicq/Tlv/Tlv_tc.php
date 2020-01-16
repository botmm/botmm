<?php
namespace botmm\GradeeBundle\Oicq\Tlv;


class Tlv_tc extends Tlv_t
{
    public function __construct()
	{
		parent::__construct();
        $this->_cmd = 12;
    }

    public function verify()
    {
        if ($this->_body_len < 14) {
            return false;
        }
        return true;
    }

    public function get_tlv_tc($in, $len)
    {
        $this->set_buf($in, $len);
    }
}
