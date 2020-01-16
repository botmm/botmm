<?php


namespace botmm\GradeeBundle\Oicq\Tlv;

use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\BufferBundle\Buffer\Buffer;

class Tlv_t144 extends Tlv_t
{
    public $_t144_body_len;

    public function __construct()
    {
        parent::__construct();
        $this->_t144_body_len = 0;
        $this->_cmd           = 324;
    }

    /**
     * @param string|byte[] $_109
     * @param string|byte[] $_124
     * @param string|byte[] $_128
     * @param string|byte[] $_147
     * @param string|byte[] $_148
     * @param string|byte[] $_151
     * @param string|byte[] $_153
     * @param $key
     * @return mixed
     */
    public function get_tlv_144()
    {
        $args = func_get_args();

        $key     = array_pop($args);
        $packs   = array_filter($args, function ($pack) {
            if ($pack != null && strlen($pack) > 0) {
                return true;
            } else {
                return false;
            }
        });
        $tlv_num = count($packs);
        $in_len  = 0;
        $in_len = array_reduce($packs, function ($prev, $pack){
            $prev += strlen($pack);
            return $prev;
        }, $in_len);
        $body = new Buffer($in_len + 2);
        $pos  = 0;
        $body->writeInt16BE($tlv_num, $pos);
        $pos += 2;
        for ($i = 0; $i < count($packs); $i++) {
            $body->write($packs[$i], $pos);
            $pos += strlen($packs[$i]);
        }
        $body                 = Cryptor::encrypt($body, 0, $pos, $key);
        $this->_t144_body_len = strlen($body);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t144_body_len);
        $this->set_length();
        return $this->get_buf();
    }

    /**
    // * @param byte[] $_109
    // * @param byte[] $_124
    // * @param byte[] $_128
    // * @param byte[] $key
    // * @return
    // */
    //public function get_tlv144_4($_109, $_124, $_128, $key)
    //{
    //    $in_len   = 0;
    //    $tlv_num  = 0;
    //    $_109_len = strlen($_109);
    //    $_124_len = strlen($_124);
    //    $_128_len = strlen($_128);
    //    $_key     = strlen($key);
    //    if ($_109 != null && $_109_len > 0) {
    //        $in_len += $_109_len;
    //        $tlv_num++;
    //    }
    //    if ($_124 != null && $_124_len > 0) {
    //        $in_len += $_124_len;
    //        $tlv_num++;
    //    }
    //    if ($_128 != null && $_128_len > 0) {
    //        $in_len += $_128_len;
    //        $tlv_num++;
    //    }
    //    $body = new Buffer($in_len + 2);
    //    $pos  = 0;
    //    $body->writeInt16BE($tlv_num, $pos);
    //    $pos += 2;
    //    if ($_109 != null && $_109_len > 0) {
    //        $body->write($_109, $pos);
    //        $pos += $_109_len;
    //    }
    //    if ($_124 != null && $_124_len > 0) {
    //        $body->write($_124, $pos);
    //        $pos += $_124_len;
    //    }
    //    if ($_128 != null && $_128_len > 0) {
    //        $body->write($_128, $pos);
    //        $pos += $_128_len;
    //    }
    //    $body                 = Cryptor::encrypt($body, 0, $pos, $key);
    //    $this->_t144_body_len = strlen($body);
    //    $this->fill_head($this->_cmd);
    //    $this->fill_body($body, strlen($body));
    //    $this->set_length();
    //    return $this->get_buf();
    //}
    //
    //public function get_tlv144_5($_109, $_124, $_128, $_147, $key)
    //{
    //    $in_len   = 0;
    //    $tlv_num  = 0;
    //    $_109_len = strlen($_109);
    //    $_124_len = strlen($_124);
    //    $_128_len = strlen($_128);
    //    $_147_len = strlen($_147);
    //    if ($_109 != null && $_109_len > 0) {
    //        $in_len = 0 + $_109_len;
    //        $tlv_num++;
    //    }
    //    if ($_124 != null && $_124_len > 0) {
    //        $in_len += $_124_len;
    //        $tlv_num++;
    //    }
    //    if ($_128 != null && $_128_len > 0) {
    //        $in_len += $_128_len;
    //        $tlv_num++;
    //    }
    //    if ($_147 != null && $_147_len > 0) {
    //        $in_len += $_147_len;
    //        $tlv_num++;
    //    }
    //    $body = new Buffer($in_len + 2);
    //    $pos  = 0;
    //    $body->writeInt16BE($tlv_num, $pos);
    //    $pos += 2;
    //    if ($_109 != null && $_109_len > 0) {
    //        $body->write($_109, $pos);
    //        $pos += $_109_len;
    //    }
    //    if ($_124 != null && $_124_len > 0) {
    //        $body->write($_124, $pos);
    //        $pos += $_124_len;
    //    }
    //    if ($_128 != null && $_128_len > 0) {
    //        $body->write($_128, $pos);
    //        $pos += $_128_len;
    //    }
    //    if ($_147 != null && $_147_len > 0) {
    //        $body->write($_147, $pos);
    //        $pos += $_147_len;
    //    }
    //    $body                 = Cryptor::encrypt($body, 0, $pos, $key);
    //    $this->_t144_body_len = strlen($body);
    //    $this->fill_head($this->_cmd);
    //    $this->fill_body($body, strlen($body));
    //    $this->set_length();
    //    return $this->get_buf();
    //}
    //
    //public function get_tlv144_6($_109, $_124, $_128, $_147, $_148, $key)
    //{
    //    $in_len   = 0;
    //    $tlv_num  = 0;
    //    $_109_len = strlen($_109);
    //    $_124_len = strlen($_124);
    //    $_128_len = strlen($_128);
    //    $_147_len = strlen($_147);
    //    $_148_len = strlen($_148);
    //    if ($_109 != null && $_109_len > 0) {
    //        $in_len += $_109_len;
    //        $tlv_num++;
    //    }
    //    if ($_124 != null && $_124_len > 0) {
    //        $in_len += $_124_len;
    //        $tlv_num++;
    //    }
    //    if ($_128 != null && $_128_len > 0) {
    //        $in_len += $_128_len;
    //        $tlv_num++;
    //    }
    //    if ($_147 != null && $_147_len > 0) {
    //        $in_len += $_147_len;
    //        $tlv_num++;
    //    }
    //    if ($_148 != null && $_148_len > 0) {
    //        $in_len += $_148_len;
    //        $tlv_num++;
    //    }
    //    $body = new Buffer($in_len + 2);
    //    $pos  = 0;
    //    $body->writeInt16BE($tlv_num, $pos);
    //    $pos += 2;
    //    if ($_109 != null && $_109_len > 0) {
    //        $body->write($_109, $pos);
    //        $pos += $_109_len;
    //    }
    //    if ($_124 != null && $_124_len > 0) {
    //        $body->write($_124, $pos);
    //        $pos += $_124_len;
    //    }
    //    if ($_128 != null && $_128_len > 0) {
    //        $body->write($_128, $pos);
    //        $pos += $_128_len;
    //    }
    //    if ($_147 != null && $_147_len > 0) {
    //        $body->write($_147, $pos);
    //        $pos += $_147_len;
    //    }
    //    if ($_148 != null && $_148_len > 0) {
    //        $body->write($_148, $pos);
    //        $pos += $_148_len;
    //    }
    //    $body                 = Cryptor::encrypt($body, 0, $pos, $key);
    //    $this->_t144_body_len = strlen($body);
    //    $this->fill_head($this->_cmd);
    //    $this->fill_body($body, strlen($body));
    //    $this->set_length();
    //    return $this->get_buf();
    //}
    //
    ///**
    // * @param $_109
    // * @param $_124
    // * @param $_128
    // * @param $_147
    // * @param $_148
    // * @param $_151
    // * @param $_153
    // * @param $key
    // * @return mixed
    // */
    //public function get_tlv144_8($_109, $_124, $_128, $_147, $_148, $_151, $_153, $key)
    //{
    //    $in_len   = 0;
    //    $tlv_num  = 0;
    //    $_109_len = strlen($_109);
    //    $_124_len = strlen($_124);
    //    $_128_len = strlen($_128);
    //    $_147_len = strlen($_147);
    //    $_148_len = strlen($_148);
    //    $_151_len = strlen($_151);
    //    $_153_len = strlen($_153);
    //    if ($_109 != null && $_109_len > 0) {
    //        $in_len += $_109_len;
    //        $tlv_num++;
    //    }
    //    if ($_124 != null && $_124_len > 0) {
    //        $in_len += $_124_len;
    //        $tlv_num++;
    //    }
    //    if ($_128 != null && $_128_len > 0) {
    //        $in_len += $_128_len;
    //        $tlv_num++;
    //    }
    //    if ($_147 != null && $_147_len > 0) {
    //        $in_len += $_147_len;
    //        $tlv_num++;
    //    }
    //    if ($_148 != null && $_148_len > 0) {
    //        $in_len += $_148_len;
    //        $tlv_num++;
    //    }
    //    if ($_151 != null && $_151_len > 0) {
    //        $in_len += $_151_len;
    //        $tlv_num++;
    //    }
    //    if ($_153 != null && $_153_len > 0) {
    //        $in_len += $_153_len;
    //        $tlv_num++;
    //    }
    //    $body = new Buffer($in_len + 2);
    //    $pos  = 0;
    //    $body->writeInt16BE($tlv_num, $pos);
    //    $pos += 2;
    //    if ($_109 != null && $_109_len > 0) {
    //        $body->write($_109, $pos);
    //        $pos += $_109_len;
    //    }
    //    if ($_124 != null && $_124_len > 0) {
    //        $body->write($_124, $pos);
    //        $pos += $_124_len;
    //    }
    //    if ($_128 != null && $_128_len > 0) {
    //        $body->write($_128, $pos);
    //        $pos += $_128_len;
    //    }
    //    if ($_147 != null && $_147_len > 0) {
    //        $body->write($_147, $pos);
    //        $pos += $_147_len;
    //    }
    //    if ($_148 != null && $_148_len > 0) {
    //        $body->write($_148, $pos);
    //        $pos += $_148_len;
    //    }
    //    if ($_151 != null && $_151_len > 0) {
    //        $body->write($_151, $pos);
    //        $pos += $_151_len;
    //    }
    //    if ($_153 != null && $_153_len > 0) {
    //        $body->write($_153, $pos);
    //        $pos += $_153_len;
    //    }
    //    $body                 = Cryptor::encrypt($body, 0, $pos, $key);
    //    $this->_t144_body_len = strlen($body);
    //    $this->fill_head($this->_cmd);
    //    $this->fill_body($body, strlen($body));
    //    $this->set_length();
    //    return $this->get_buf();
    //}
}
