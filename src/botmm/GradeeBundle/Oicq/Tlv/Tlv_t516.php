<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


class Tlv_t516 extends Tlv_t
{
    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 0x516;
    }

    /**
     * WUserSignInfo $source_type
     * @param $source_type 0
     * @return mixed
     */
    public function get_tlv_516($source_type)
    {
        $this->fill_head($this->_cmd);
        $this->fill_body($source_type, 4);
        $this->set_length();
        return $this->get_buf();
    }

}