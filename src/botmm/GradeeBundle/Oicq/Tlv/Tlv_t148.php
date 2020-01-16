<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t148 extends Tlv_t
{
    public function __construct()
	{
		parent::__construct();
        $this->_cmd = 328;
    }

    private function limit_len($data, $max_len)
    {
        if ($data == null) {
            return 0;
        }
        if (strlen($data) > $max_len) {
            return $max_len;
        }
        return strlen($data);
    }

    public function get_tlv_148($appName, $ssoVer, $appID, $subAppID, $appVer, $appSign)
    {
        $appName_len = $this->limit_len($appName, 32);
        $appVer_len  = $this->limit_len($appVer, 32);
        $appSign_len = $this->limit_len($appSign, 32);
        $body        = new Buffer((((((((($appName_len + 2) + 4) + 4) + 4) + 2) + $appVer_len) + 2) + $appSign_len));
        $pos         = 0;
        $body->writeInt16BE($appName_len, 0);
        $pos += 2;
        $body->write($appName, $pos, $appName_len);
        $pos += $appName_len;
        $body->writeInt32BE($ssoVer, $pos);
        $pos += 4;
        $body->writeInt32BE($appID, $pos);
        $pos += 4;
        $body->writeInt32BE($subAppID, $pos);
        $pos += 4;
        $body->writeInt16BE($appVer_len, $pos);
        $pos += 2;
        $body->write($appVer, $pos, $appVer_len);
        $pos += $appVer_len;
        $body->writeInt16BE($appSign_len, $pos);
        $pos += 2;
        $body->write($appSign, $pos, $appSign_len);
        $pos += $appSign_len;
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $pos);
        $this->set_length();
        return $this->get_buf();
    }
}
