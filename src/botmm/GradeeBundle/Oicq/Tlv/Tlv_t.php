<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Tools\Hex;
use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t
{
    protected $_body_len;
    /**
     * @var Buffer
     */
    protected $_buf;
    protected $_cmd;
    protected $_head_len;
    protected $_max;
    protected $_pos;

    //protected $_type;

    public function __construct()
    {
        $this->_max = 128;
        $this->_pos = 0;
        //$this->_type     = 0;
        $this->_head_len = 4;
        $this->_body_len = 0;
        $this->_buf      = new Buffer($this->_max);
        $this->_cmd      = 0;
    }

    //public function get_type()
    //{
    //    return $this->_cmd;
    //}

    public function get_buf()
    {
        return $this->_buf->read(0, $this->_pos);
    }

    public function get_data()
    {
        return $this->_buf->read($this->_head_len, $this->_body_len - $this->_head_len);
    }

    public function get_data_len()
    {
        return $this->_body_len;
    }

    /**
     * @param string $in
     * @param int    $len
     */
    public function set_data($in, $len)
    {
        if ($this->_head_len + $len > $this->_max) {
            $this->_max = ($this->_head_len + $len) + 128;
            $buf1       = new Buffer($this->_max);
            $buf1->write($this->_buf, 0, $this->_head_len);
            $this->_buf = $buf1;
        }
        $this->_pos = $this->_head_len + $len;
        $this->_buf->write($in, $this->_head_len, $len);
        $this->_body_len = $len;
        $this->_buf->writeInt16BE($this->_cmd, 0);
        $this->_buf->writeInt16BE($this->_body_len, 2);
    }

    public function set_buf()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 2:
                return call_user_func_array([$this, 'set_buf2'], $args);
            case 3:
                return call_user_func_array([$this, 'set_buf3'], $args);
            case 5:
                return call_user_func_array([$this, 'set_buf5'], $args);
            default:
                throw new \InvalidArgumentException("set_buf arguments error");
        }
    }

    /**
     * @param string $in
     * @param int    $len
     */
    private function set_buf2($in, $len)
    {
        if ($len > $this->_max) {
            $this->_max = $len + 128;
            $this->_buf = new Buffer($this->_max);
        }
        $this->_pos = $len;
        $this->_buf = new Buffer($len);
        $this->_buf->write($in, 0);
        $this->_cmd      = $this->_buf->readInt16BE(0);
        $this->_body_len = $len - $this->_head_len;
    }

    /**
     * @param string $in
     * @param  int   $pos
     * @param  int   $len
     */
    private function set_buf3($in, $pos, $len)
    {
        if ($len > $this->_max) {
            $this->_max = $len + 128;
            $this->_buf = new Buffer($this->_max);
        }
        $this->_pos = $len;
        $inBuffer   = new Buffer($in);
        $this->_buf->write($inBuffer->read($pos, $len), $pos, $len);
        $this->_cmd      = $inBuffer->readInt16BE(0);
        $this->_body_len = $len - $this->_head_len;
    }

    private function set_buf5($in, $pos, $len, $cmd, $body_len)
    {
        if ($len > $this->_max) {
            $this->_max = $len + 128;
            $this->_buf = new Buffer($this->_max);
        }
        $this->_pos = $len;
        $this->_buf->write((new Buffer($in))->read($pos, $len), 0, $len);
        $this->_cmd      = $cmd;
        $this->_body_len = $body_len;
    }

    public function fill_head($type)
    {
        $this->_buf->writeInt16BE($type, $this->_pos);
        $this->_pos += 2;
        $this->_buf->writeInt16BE(0, $this->_pos);
        $this->_pos += 2;
    }

    public function set_length()
    {
        $this->_buf->writeInt16BE($this->_pos - $this->_head_len, 2);
    }

    public function fill_body($in, $len)
    {
        if ($len > $this->_max - $this->_head_len) {
            $this->_max = ($this->_head_len + $len) + 64;
            $new_buf    = new Buffer($this->_max);
            $new_buf->write($this->_buf, 0, $this->_pos);
            $this->_buf = $new_buf;
        }
        $this->_body_len = $len;
        $this->_buf->write($in, $this->_pos, $len);
        $this->_pos += $len;
    }

    function search_tlv($in, $pos, $len, $type)
    {
        //if($len == null){
        $max      = strlen($in);
        //}
        $inBuffer = new Buffer($in);
        while ($pos < $max && $pos + 2 <= $max) {
            if ($inBuffer->readInt16BE($pos) == $type) {
                return $pos;
            }
            $pos += 2;
            if ($pos + 2 > $max) {
                return -1;
            }
            $pos += $inBuffer->readInt16BE($pos) + 2;
        }
        return -1;
    }

    /**
     *
     * <p>
     *     <b>param</b> string $in  <br/>
     *     <b>param</b> int    $len        <br/>
     *     <b>return</b> int|string <br/>
     * </p>
     *<br/>
     * <p>
     *     <b>param</b> string $in  <br/>
     *     <b>param</b> int    $pos        <br/>
     *     <b>param</b> int    $len        <br/>
     *     <b>return</b> int|string <br/>
     * </p>
     *<br/>
     * <p>
     *     <b>param</b> string $in  <br/>
     *     <b>param</b> int    $pos        <br/>
     *     <b>param</b> int    $len        <br/>
     *     <b>param</b> string $key        <br/>
     *     <b>return</b> int|string <br/>
     * </p>
     */
    public function get_tlv()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 2:
                return call_user_func_array([$this, 'get_tlv2'], $args);
            case 3:
                if (is_int($args[2])) {
                    return call_user_func_array([$this, 'get_tlv3'], $args);
                } else {
                    return call_user_func_array([$this, 'get_tlv_cryptor'], $args);
                }
            case 4:
                return call_user_func_array([$this, 'get_tlv4'], $args);
            default:
                throw new \InvalidArgumentException("get_tlv arguments error");
        }
    }

    private function get_tlv2($in, $len)
    {
        if ($this->_head_len >= $len) {
            return -1;
        }
        $inBuffer        = new Buffer($in);
        $this->_body_len = $inBuffer->readInt16BE(2);
        if ($this->_head_len + $this->_body_len > $len) {
            return -1;
        }
        $this->set_buf2($in, $this->_head_len + $this->_body_len);
        if ($this->verify()) {
            return 0;
        }
        return -1005;
    }

    /**
     * @param string $in
     * @param int    $pos
     * @param int    $len
     * @return int
     */
    private function get_tlv3($in, $pos, $len)
    {
        $p = $this->search_tlv($in, $pos, $len, $this->_cmd);
        if ($p < 0) {
            return -1;
        }
        $len -= $p - $pos;
        $pos = $p;
        if ($this->_head_len >= $len) {
            return -1;
        }
        $inBuffer        = new Buffer($in);
        $this->_body_len = $inBuffer->readInt16BE($pos + 2);
        if ($this->_head_len + $this->_body_len > $len) {
            return -1;
        }
        $this->set_buf3($in, $pos, $this->_head_len + $this->_body_len);
        if ($this->verify()) {
            return ($this->_head_len + $p) + $this->_body_len;
        }
        return -1005;
    }

    /**
     * @param string $in
     * @param int    $pos
     * @param int    $len
     * @param string $key
     * @return int|string
     */
    private function get_tlv4($in, $pos, $len, $key)
    {
        $p = $this->search_tlv($in, $pos, $len, $this->_cmd);
        if ($p < 0) {
            return -1;
        }
        $len -= $p - $pos;
        $in1 = new Buffer($len);
        $in1->write((new Buffer($in))->read($p, $len), 0, $len);
        return $this->get_tlv_cryptor($in1, $len, $key);
    }

    /**
     * @param $in
     * @param $len
     * @param $key
     * @return int
     */
    function get_tlv_cryptor($in, $len, $key)
    {
        if ($this->_head_len >= $len) {
            return -1;
        }
        $inBuffer        = new Buffer($in);
        $this->_body_len = $inBuffer->readInt16BE(2);
        if ($this->_head_len + $this->_body_len > $len) {
            return -1;
        }
        $decrypt_body        = Cryptor::decrypt($in, $this->_head_len, $this->_body_len, $key);
        $decrypt_body_length = strlen($decrypt_body);
        if ($decrypt_body == null) {
            return -1015;
        }
        if ($this->_head_len + $decrypt_body_length > $this->_max) {
            $this->_max = $this->_head_len + strlen($decrypt_body);
            $this->_buf = new Buffer($this->_max);
        }
        $this->_pos = 0;
        $this->_buf->write($in, 0, $this->_head_len);
        $this->_pos += $this->_head_len;
        $this->_buf->write($decrypt_body, $this->_pos, $decrypt_body_length);
        $this->_pos += $decrypt_body_length;
        $this->_body_len = $decrypt_body_length;
        return !$this->verify() ? -1005 : 0;
    }


    /**
     * @return bool
     */
    public function verify()
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function get_sizeof()
    {
        return $this->_pos;
    }

    public function __toString()
    {

        return Hex::BinToHexString((string)$this->_buf);
    }
}
