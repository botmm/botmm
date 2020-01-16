<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

/**
 * Class tlv_t138
 *
 * 10a 11c 120 136 102 103 143 164
 *
 * @package botmm\GradeeBundle\Tlv
 */
class Tlv_t138 extends Tlv_t
{
    protected $_count;

    public function __construct()
    {
        parent::__construct();
        $this->_count = 0;
        $this->_cmd   = 0x138;
    }

    public function verify()
    {
        if ($this->_body_len < 4) {
            return false;
        }
        if ($this->_body_len < ($this->_count * 10) + 4) {
            return false;
        }

        return true;
    }

    public function get_a2_chg_time()
    {
        for ($i = 0; $i < $this->_count; $i++) {
            if ($this->_buf->readInt16BE(($this->_head_len + 4) + ($i * 10)) == 0x10a) {
                return $this->_buf->readInt32BE((($this->_head_len + 4) + ($i * 10)) + 2);
            }
        }
        return 0;
    }

    public function get_lskey_chg_time()
    {
        for ($i = 0; $i < $this->_count; $i++) {
            if ($this->_buf->readInt16BE(($this->_head_len + 4) + ($i * 10)) == 0x11c) {
                return $this->_buf->readInt32BE((($this->_head_len + 4) + ($i * 10)) + 2);
            }
        }
        return 0;
    }

    public function get_skey_chg_time()
    {
        for ($i = 0; $i < $this->_count; $i++) {
            if ($this->_buf->readInt16BE(($this->_head_len + 4) + ($i * 10)) == 0x120) {
                return $this->_buf->readInt32BE((($this->_head_len + 4) + ($i * 10)) + 2);
            }
        }
        return 0;
    }

    public function get_vkey_chg_time()
    {
        for ($i = 0; $i < $this->_count; $i++) {
            if ($this->_buf->readInt16BE(($this->_head_len + 4) + ($i * 10)) == 0x136) {
                return $this->_buf->readInt32BE((($this->_head_len + 4) + ($i * 10)) + 2);
            }
        }
        return 0;
    }

    public function get_a8_chg_time()
    {
        for ($i = 0; $i < $this->_count; $i++) {
            if ($this->_buf->readInt16BE(($this->_head_len + 4) + ($i * 10)) == 0x102) {
                return $this->_buf->readInt32BE((($this->_head_len + 4) + ($i * 10)) + 2);
            }
        }
        return 0;
    }

    public function get_stweb_chg_time()
    {
        for ($i = 0; $i < $this->_count; $i++) {
            if ($this->_buf->readInt16BE(($this->_head_len + 4) + ($i * 10)) == 0x103) {
                return $this->_buf->readInt32BE((($this->_head_len + 4) + ($i * 10)) + 2);
            }
        }
        return 0;
    }

    public function get_d2_chg_time()
    {
        for ($i = 0; $i < $this->_count; $i++) {
            if ($this->_buf->readInt16BE(($this->_head_len + 4) + ($i * 10)) == 0x143) {
                return $this->_buf->readInt32BE((($this->_head_len + 4) + ($i * 10)) + 2);
            }
        }
        return 0;
    }

    public function get_sid_chg_time()
    {
        for ($i = 0; $i < $this->_count; $i++) {
            if ($this->_buf->readInt16BE(($this->_head_len + 4) + ($i * 10)) == 0x164) {
                return $this->_buf->readInt32BE((($this->_head_len + 4) + ($i * 10)) + 2);
            }
        }
        return 0;
    }
}

