<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t16b extends Tlv_t
{

    public function __construct()
    {
        parent::__construct();
        $this->_cmd = 363;
    }

    /*
     * Enabled aggressive block sorting
     */
    public function get_tlv_16b($list)
    {
        $n3        = 0;
        $total_len = 0;
        $num    = 0;
        if ($list != null) {
            $num = count($list);
            $index  = 0;
            do {
                if ($index >= $num) {
                    break;
                }
                $total_len += 2;
                if ($list[$index] != null) {
                    $total_len += strlen($list[$index]);
                }
                ++$index;
            } while (true);
        }

        $body = new Buffer($total_len + 2);
        $pos   = 0;
        $body->writeInt16BE($num, $pos);
        $pos += 2;
        if ($list != null) {
            for ($i = 0; $i < $n3; ++$i) {
                if ($list[$i] != null) {
                    $item     = $list[$i];
                    $item_len = strlen($item);
                    $body->writeInt16BE($item_len, $pos);
                    $pos += 2;
                    $body->write($item, $pos, $item_len);
                    $pos += $item_len;
                    continue;
                }
                $body->writeInt16BE(0, $pos);
                $pos += 2;
            }
        }
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $pos);
        $this->set_length();
        return $this->get_buf();
    }
}
