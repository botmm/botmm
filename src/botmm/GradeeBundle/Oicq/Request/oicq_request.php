<?php


namespace botmm\GradeeBundle\Request;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t102;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t103;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t104;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t105;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t106;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t108;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t10a;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t10b;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t10c;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t10d;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t10e;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t113;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t114;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t119;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t11a;
use botmm\GradeeBundle\Oicq\Tlv\tlv_t11c;
use botmm\GradeeBundle\Oicq\Tlv\tlv_t11d;
use botmm\GradeeBundle\Oicq\Tlv\tlv_t11f;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t120;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t121;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t122;
use botmm\GradeeBundle\Oicq\Tlv\tlv_t125;
use botmm\GradeeBundle\Oicq\Tlv\tlv_t126;
use botmm\GradeeBundle\Oicq\Tlv\tlv_t129;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t130;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t132;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t133;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t134;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t136;
use botmm\GradeeBundle\Oicq\Tlv\tlv_t138;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t143;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t149;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t150;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t164;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t165;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t167;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t169;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t16a;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t171;
use botmm\GradeeBundle\Oicq\Tlv\Tlv_t305;

class oicq_request
{
    /** byte[] */
    static $_recv_ret_buf;
    /** String */
    static $_save_host;
    /** String[] */
    static $_static_web_wlogin_ip;
    /** String[] */
    static $_static_wlogin_ip;
    /** int */
    static $_test;
    /** String */
    static $_test_host;
    /** int */
    static $_test_push;
    /** String */
    static $_test_push_host;
    /** byte[] */
    protected $_buf;
    /** int */
    protected $_cmd;
    /** int */
    protected $_default_client_seq;
    /** int */
    protected $_default_client_version;
    /** int */
    protected $_default_ext_instance;
    /** int */
    protected $_default_ext_no;
    /** int */
    protected $_default_ext_retry;
    /** int */
    protected $_default_ext_type;
    /** int */
    protected $_default_ext_version;
    /** int */
    protected $_default_ext_version1;
    /** request_global */
    public $_g;
    /** int */
    private $_max;
    /** int */
    private $_msf_seq;
    /** int */
    private $_pos;
    /** int */
    private $_rep_body_len;
    /** int */
    private $_req_head_len;
    /** byte */
    private $_ret;
    /** int */
    protected $_rsp_body_len;
    /** int */
    public $_rsp_head_len;
    /** InetSocketAddress */
    private $_server_ip;
    /** int */
    private $_server_port;
    /** String */
    protected $_service_cmd;
    /** int */
    protected $_sub_cmd;


    public function __construct()
    {
        self::$_recv_ret_buf         = new Buffer(10240);
        self::$_static_wlogin_ip     = [
            "183.60.18.138",
            "112.90.85.191",
            "112.90.85.193",
            "183.60.18.150",
            "120.196.212.233",
            "120.204.200.34",
            "27.115.124.244"
        ];
        self::$_static_web_wlogin_ip = [
            "112.90.141.41",
            "112.90.141.48",
            "113.108.11.157",
            "113.108.11.159",
            "120.196.212.232"
        ];
        self::$_test                 = 0;
        self::$_test_host            = "";
        self::$_save_host            = "";
        self::$_test_push            = 0;
        self::$_test_push_host       = "";

        $this->_max                    = 4096;
        $this->_pos                    = 0;
        $this->_req_head_len           = 27;
        $this->_rep_body_len           = 0;
        $this->_rsp_head_len           = 15;
        $this->_rsp_body_len           = 0;
        $this->_buf                    = new Buffer($this->_max);
        $this->_default_client_version = 8001;//pc_ver
        $this->_default_client_seq     = 0;
        $this->_default_ext_version    = 3;
        $this->_default_ext_version1   = 0;
        $this->_default_ext_retry      = 0;
        $this->_default_ext_type       = 0;
        $this->_default_ext_no         = 0;
        $this->_default_ext_instance   = 0;
        $this->_server_ip              = null;
        $this->_server_port            = 0;
        $this->_cmd                    = 0;
        $this->_sub_cmd                = 0;
        $this->_service_cmd            = "";
        $this->_msf_seq                = 0;
    }

    public function get_static_ip(bool $is_wap_retry)
    {
        if ($is_wap_retry) {
            return self::$_static_web_wlogin_ip[((int)(mt_rand())) % count(static::$_static_web_wlogin_ip)];
        }

        return self::$_static_wlogin_ip[((int)(mt_rand())) % count(static::$_static_wlogin_ip)];
    }

    public static function set_test(int $test, string $host)
    {
        self::$_test      = $test;
        self::$_test_host = $host;
    }

    public
    static function set_push_test(
        int $test,
        string $host
    ) {
        self::$_test_push      = $test;
        self::$_test_push_host = $host;
    }

    public function fill_head(
        int $version,
        int $cmd,
        int $seq,
        long $uin,
        int $retry,
        int $type,
        int $no,
        int $instance,
        int $body_len
    ) {
        $this->_default_client_seq++;

        $this->_pos = 0;
        $this->_buf->writeInt8(2, $this->_pos);
        $this->_pos++;
        $this->_buf->writeInt16BE(($this->_req_head_len + 2) + $body_len, $this->_pos);
        $this->_pos += 2;
        $this->_buf->writeInt16BE($version, $this->_pos);
        $this->_pos += 2;
        $this->_buf->writeInt16BE($cmd, $this->_pos);
        $this->_pos += 2;
        $this->_buf->writeInt16BE($this->_default_client_seq, $this->_pos);
        $this->_pos += 2;
        $this->_buf->writeInt32BE($uin, $this->_pos);
        $this->_pos += 4;
        $this->_buf->writeInt8(3, $this->_pos);
        $this->_pos++;
        $this->_buf->writeInt8(0, $this->_pos);
        $this->_pos++;
        $this->_buf->writeInt8($retry, $this->_pos);
        $this->_pos++;
        $this->_buf->writeInt32BE($type, $this->_pos);
        $this->_pos += 4;
        $this->_buf->writeInt32BE($no, $this->_pos);
        $this->_pos += 4;
        $this->_buf->writeInt32BE($instance, $this->_pos);
        $this->_pos += 4;
    }

    public function fill_end()
    {
        $this->_buf->writeInt8(3, $this->_pos);
        $this->_pos++;
    }

    /**
     * @param string|byte[] $body
     * @param int           $len
     */
    public function fill_body($body, int $len)
    {
        if (($this->_pos + $len) + 1 > $this->_max) {
            $this->_max = (($this->_pos + $len) + 1) + 128;
            $new_buf    = new Buffer($this->_max);
            $new_buf->write($this->_buf->read(0, $this->_pos), 0);
            $this->_buf = $new_buf;
        }

        $this->_buf->write($body, 0, $len);
        $this->_pos += $len;
    }

    public function fill(
        int $version,
        int $cmd,
        int $seq,
        long $uin,
        int $retry,
        int $type,
        int $no,
        int $intstance,
        string $body,
        int $body_len
    ) {
        $this->fill_head($version, $cmd, $seq, $uin, $retry, $type, $no, $intstance, $body_len);
        $this->fill_body($body, $body_len);
        $this->fill_end();
    }

    public function get_request(
        int $version,
        int $cmd,
        int $seq,
        long $uin,
        int $retry,
        int $type,
        int $no,
        int $intstance,
        $body
    ) {
        $this->fill(
            $version,
            $cmd,
            $seq,
            $uin,
            $retry,
            $type,
            $no,
            $intstance,
            $body,
            strlen($body));
    }

    public function get_response()
    {
        $len = $this->_pos;
        if ($len <= $this->_rsp_head_len + 2) {
            return -1009;
        }
        $this->_rsp_body_len = ($len - $this->_rsp_head_len) - 2;
        $ret                 = $this->decrypt_body($this->_buf, $this->_rsp_head_len + 1, $this->_rsp_body_len,
                                                   $this->_g->_rand_key);
        if ($ret < 0) {
            return $ret;
        }
        return $this->get_response_body($this->_buf, $this->_rsp_head_len + 1, $this->_rsp_body_len);
    }

    public
    function set_buf(
        $in,
        int $len
    ) {
        if ($len > $this->_max) {
            $this->_max = $len + 128;
            $this->_buf = new Buffer($this->_max);
        }

        $this->_pos = $len;
        $this->_buf->write($in, 0, $len);
    }

    public function get_buf()
    {
        return $this->_buf->readBuffer(0, $this->_pos);
    }

    public function decrypt_body(
        $in,
        int $pos,
        int $len,
        $key
    ) {
        $dbody               = Cryptor::decrypt($in, $pos, $len, $key);
        $dbody_len           = strlen($dbody);
        $this->_rsp_body_len = $dbody_len;
        if (($dbody_len + $this->_rsp_head_len) + 2 > $this->_max) {
            $this->_max = ($dbody_len + $this->_rsp_head_len) + 2;
            $new_buf    = new Buffer($this->_max);
            $new_buf->write($this->_buf->readBuffer(0, $this->_pos), 0);
            $this->_buf = $new_buf;
        }
        $this->_pos = 0;
        $this->_buf->write($dbody, $pos, $dbody_len);
        $this->_pos += ($this->_rsp_head_len + 2) + $dbody_len;
        return 0;
    }

    function encrypt_body($in, int $sub_cmd, int $tlv_num)
    {
        $in_len = strlen($in);
        $body   = new Buffer($in_len + 4);
        $body->writeInt16BE($sub_cmd, 0);
        $body->writeInt16BE($tlv_num, 2);
        $body->write($in, 4, $in_len);
        //util->LOGD("encrypt_body key:" + util->buf_to_string($this->_g->_rand_key));
        $en_buf     = Cryptor::encrypt($body, 0, $in_len + 4, $this->_g->_rand_key);
        $en_buf_len = strlen($en_buf);
        $ret        = new Buffer($en_buf_len + $this->_g->_rand_key->length);
        $ret->write($this->_g->_rand_key, 0);
        $ret->write($en_buf, strlen($this->_g->_rand_key));
        return $ret;
    }

    protected function encrypt_body1($in)
    {
        //util->LOGD("encrypt_body key:" + util->buf_to_string($this->_g->_rand_key));
        $en_buf        = Cryptor:: encrypt($in, 0, strlen($in), $this->_g->_rand_key);
        $en_buf_len    = strlen($en_buf);
        $_rand_key_len = strlen($this->_g->_rand_key);
        $ret           = new Buffer($en_buf_len + $_rand_key_len);
        $ret->write($this->_g->_rand_key, 0);
        $ret->write($en_buf, $_rand_key_len);
        return $ret;
    }

    public function get_sk()
    {
        return $this->_g->_sk;
    }

    public function set_sk(Socket $sk)
    {
        $this->_g->_sk = $sk;
    }

    public function get_host(boolean $is_wap_retry)
    {
        $host_array = [];
        if ($is_wap_retry) {
            $host_array[0] = "wlogin.qq.com";
            $host_array[1] = "wlogin1.qq.com";
        } else {
            $host_array[0] = "wtlogin.qq.com";
            $host_array[1] = "wtlogin1.qq.com";
        }
        return $host_array[abs(round(rand(0, 100)) % 2)];
    }

    public function get_port(boolean $is_wap_retry)
    {
        return $is_wap_retry ? 443 : 443;
    }

    public function resolve_server_addr(
        int $retry_no,
        boolean $is_wap_retry
    ) {
        $host = "";
        $retry_no /= 2;
        if (self::$_test != 0 && self::$_test_host != null && strlen(self::$_test_host) > 0) {
            $host = self::$_test_host;
        } else {
            if ($retry_no < 1) {
                if ($is_wap_retry) {
                    if ($this->_g->_network_type == 1) {
                        $host = new String(util::get_wap_server_host1($this->_g->_context));
                    } else {
                        if ($this->_g->_network_type == 2) {
                            $host = new String(util::get_wap_server_host2($this->_g->_context));
                        }
                    }
                } else {
                    if ($this->_g->_network_type == 1) {
                        $host = new String(util::get_server_host1($this->_g->_context));
                    } else {
                        if ($this->_g->_network_type == 2) {
                            $host = new String(util::get_server_host2($this->_g->_context));
                        }
                    }
                }
                if (host == null || host->length() <= 0) {
                    $host = get_host(is_wap_retry);
                }
            } else {
                if (retry_no < 2) {
                    $host = get_host(is_wap_retry);
                } else {
                    $host = get_static_ip(is_wap_retry);
                }
            }
        }
        $_save_host = $host;
        //util->LOGD("resolve_server_addr OK", "host:" + host + " tryno:" + retry_no);
        return $host;
    }

    public function snd_rcv_req(string $uin, boolean $flag, WUserSigInfo $userSigInfo)
    {
        if ($this->_g->is_use_msf_transport()) {
            return $this->snd_rcv_req_msf($uin, $flag, $userSigInfo);
        }
        return $this->snd_rcv_req_tcp();
    }

    public function snd_rcv_req_msf(string $uin, boolean $flag, WUserSigInfo $userSigInfo)
    {
        //$ret;
        //util->LOGI(new StringBuilder(String->valueOf(getClass()->getName()))->append(":snd_rcv_req_msf ...")->toString(), $this->_g->_context, $this->_g->_uin, 0);
        $timeout = $this->_g->_time_out;
        $buf     = $this->get_buf();
        $data    = null;
        $start   = time();//System->currentTimeMillis();
        //try {
        //util->LOGI("WtloginMsfListener uin:" + uin + " service_cmd:" + $this->_service_cmd + " timeout:" + timeout + " flag:" + flag, $this->_g->_context, $this->_g->_uin, 0);
        //todo msflisten $this->set_buf();
        //WtloginMsfListener msfListener = new WtloginMsfListener(uin, $this->_service_cmd, buf, timeout, flag,
        //                                                        userSigInfo);
        //    Thread thread = new Thread(msfListener);
        //    thread->start();
        //    thread->join((long) timeout);
        //    data = msfListener->getRetData();
        //    if (data == null) {
        //        util->LOGI("recv data from server failed, ret=" + msfListener->getRet(), $this->_g->_context,
        //                    $this->_g->_uin, 0);
        //        ret = util->E_NO_RET;
        //    } else {
        //        todo
        //        set_buf(data, data->length);
        //        ret = 0;
        //    }
        //} catch (\Exception $e) {
        //    Writer sw = new StringWriter();
        //    PrintWriter pw = new PrintWriter(sw, true);
        //    e->printStackTrace(pw);
        //    pw->flush();
        //    sw->flush();
        //    String s = sw->toString();
        //    String str = s;
        //    util->LOGW("exception", str, $this->_g->_context, $this->_g->_uin);
        //    ret = util->E_NO_RET;
        //}
        if ($this->_cmd != 2066) {
            //report_t3 rt3 = new report_t3();
            //rt3->_cmd    = $this->_cmd;
            //rt3->_sub    = $this->_sub_cmd;
            //rt3->_rst2   = ret;
            //rt3->_used   = (int)(System->currentTimeMillis() - start);
            //rt3->_try    = 0;
            //rt3->_host   = "";
            //rt3->_ip     = "";
            //rt3->_port   = 0;
            //rt3->_conn   = 0;
            //rt3->_net    = 0;
            //rt3->_str    = "";
            //if (ret == 0) {
            //    rt3->_slen = buf->length;
            //    rt3->_rlen = data->length;
            //} else {
            //    rt3->_slen = 0;
            //    rt3->_rlen = 0;
            //}
            //rt3->_wap = 3;
            //$this->_g->_rt1->add_t3(rt3);
            print_r("report_t3 cmd:{$this->_cmd} sub_cmd: {$this->_sub_cmd}");
        }
        //util->LOGI(new StringBuilder(String->valueOf(getClass()->getName()))->append(":snd_rcv_req_msf ret=")->append(ret)->toString(),
        //            $this->_g->_context, $this->_g->_uin, 1);
        return $ret;
    }

    public function get_rsp_length($head)
    {
        return $head->readInt16BE(1);
    }

    public function get_response_ret_code(
        $in,
        int $pos
    ) {
        $this->_ret     = $in[$pos];
        $this->_g->_ret = $this->_ret;
        return $in[$pos];
    }

    public function get_response_ret_code()
    {
        return $this->_ret;
    }

    public function get_response_ret_tlv_num(
        $in,
        int $pos
    ) {
        return (in[pos] << 8) + in[pos + 1];
    }

    public function get_ret_code()
    {
        return $this->_ret;
    }

    public function get_sizeof()
    {
        return $this->_pos;
    }

    public function get_err_msg($in, int $pos, int $len)
    {
        $t146 = new Tlv_t146();
        if ($t146->get_tlv($in, $pos, $len) >= 0) {
            $this->_g->_last_err_msg->setTitle(new String($t146->get_title()));
            $this->_g->_last_err_msg->setMessage(new String($t146->get_msg()));
            $this->_g->_last_err_msg->setType($t146->get_type());
            $this->_g->_last_err_msg->setOtherinfo(new String($t146->get_errorinfo()));
            return;
        }
        $this->_g->_last_err_msg->ClearMsg();
    }

    public function set_err_msg(ErrMsg $errMsg)
    {
        $this->_g->_last_err_msg->ClearMsg();
        if ($errMsg != null) {
            try {
                $this->_g->_last_err_msg = $errMsg->clone();
            } catch (\Exception $e) {
                $this->_g->_last_err_msg->ClearMsg();
            }
        }
    }

    public function show_alert_dialog(Tlv_t149 $t149)
    {
        $errMsg = [];
        if ($t149 != null) {
            $errMsg['setType']      = $t149->get_type();
            $errMsg['setTitle']     = $t149->get_title();
            $errMsg['setMessage']   = $t149->get_content();
            $errMsg['setOtherinfo'] = $t149->get_otherinfo();
            print_r($errMsg);
        }

    }

    public function encrypt_a1($a1)
    {
        $in = new Buffer(strlen($a1) + strlen($this->_g->_key_tgtgt));
        $in->write($a1, 0);
        $in->write($this->_g->_key_tgtgt, strlen($a1));
        return $in;
    }

    public function decrypt_a1($en_a1)
    {
        $key = "%4;7t>;28<fc.5*6";
        if ($this->request_global->_IMEI_KEY == null || $this->request_global->_IMEI_KEY->length <= 0) {
            $ret = Cryptor::decrypt($en_a1, 0, strlen($en_a1), $key->getBytes());
        } else {
            $key1 = new Buffer(16);
            $key1->write($this->request_global->_IMEI_KEY, 0, 16);
            $ret = Cryptor::decrypt($en_a1, 0, strlen($en_a1), $key1);
        }
        if ($ret == null || strlen($ret) < 16) {
            return null;
        }
        $a1_len = strlen($ret) - 16;
        $ret1   = new Buffer($a1_len);
        $ret1->write($ret, $a1_len);
        $this->_g->_key_tgtgt = new Buffer(16);
        $this->_g->_key_tgtgt = $ret->read($a1_len, 16);
        //util->LOGD("decrypt_a1:a1", util->buf_to_string(ret1));
        //util->LOGD("decrypt_a1:_key_tgtgt", util->buf_to_string($this->_g->_key_tgtgt));
        return $ret1;
    }

    public function set_last_flowid(int $flowid)
    {
        $this->_g->_last_flowid = $flowid;
        return $flowid;
    }

    public function get_last_flowid()
    {
        return $this->_g->_last_flowid;
    }

    public function on_return_A1($a1)
    {
        $this->_g->_fast_login_info = $a1;
    }

    public function get_response_body($in, int $pos, int $len)
    {
        $flowid    = null;
        $tk_expire = 2880;
        $a2_expire = 2160000;
        /*Tlv_t104*/
        $t104 = new Tlv_t104();
        /*Tlv_t105*/
        $t105 = new Tlv_t105();
        /*Tlv_t113*/
        $t113 = new Tlv_t113();
        /*Tlv_t119*/
        $t119 = new Tlv_t119();
        /*Tlv_t10d*/
        $t10d = new Tlv_t10d();
        /*Tlv_t10e*/
        $t10e = new Tlv_t10e();
        /*Tlv_t10a*/
        $t10a = new Tlv_t10a();
        /*Tlv_t114*/
        $t114 = new Tlv_t114();
        /*Tlv_t103*/
        $t103 = new Tlv_t103();
        /*Tlv_t11a*/
        $t11a = new Tlv_t11a();
        /*Tlv_t102*/
        $t102 = new Tlv_t102();
        /*Tlv_t10b*/
        $t10b = new Tlv_t10b();
        /*Tlv_t11c*/
        $t11c = new Tlv_t11c();
        /*Tlv_t11d*/
        $t11d = new Tlv_t11d();
        /*Tlv_t120*/
        $t120 = new Tlv_t120();
        /*Tlv_t121*/
        $t121 = new Tlv_t121();
        /*Tlv_t130*/
        $t130 = new Tlv_t130();
        /*Tlv_t108*/
        $t108 = new Tlv_t108();
        /*Tlv_t106*/
        $t106 = new Tlv_t106();
        /*Tlv_t10c*/
        $t10c = new Tlv_t10c();
        /*Tlv_t125*/
        $t125 = new Tlv_t125();
        /*Tlv_t122*/
        $t122 = new Tlv_t122();//fixme sames that it have been removed from 4.7
        /*Tlv_t126*/
        $t126 = new Tlv_t126();
        /*Tlv_t129*/
        $t129 = new Tlv_t129();//fixme sames that it have been removed from 4.7
        /*Tlv_t11f*/
        $t11f = new Tlv_t11f();
        /*Tlv_t138*/
        $t138 = new Tlv_t138();
        /*Tlv_t132*/
        $t132 = new Tlv_t132();
        /*Tlv_t149*/
        $t149 = new Tlv_t149();
        /*Tlv_t150*/
        $t150 = new Tlv_t150();
        /*Tlv_t143*/
        $t143 = new Tlv_t143();
        /*Tlv_t305*/
        $t305 = new Tlv_t305();
        /*Tlv_t164*/
        $t164 = new Tlv_t164();
        /*Tlv_t165*/
        $t165 = new Tlv_t165();
        /*Tlv_t167*/
        $t167 = new Tlv_t167();
        /*Tlv_t16a*/
        $t16a = new Tlv_t16a();
        /*Tlv_t169*/
        $t169 = new Tlv_t169();

        // todo add it
        ///*Tlv_t161*/
        //$t161 = new Tlv_t161();
        ///*Tlv_t171*/
        //$t171 = new Tlv_t171();
        ///*Tlv_t16c*/
        //$t16c = new Tlv_t16c();
        ///*Tlv_t16d*/
        //$t16d = new Tlv_t16d();
        ///*Tlv_t174*/
        //$t174 = new Tlv_t174();
        ///*Tlv_t178*/
        //$t178 = new Tlv_t178();
        ///*Tlv_t179*/
        //$t179 = new Tlv_t179();
        ///*Tlv_t17d*/
        //$t17d = new Tlv_t17d();
        ///*Tlv_t17e*/
        //$t17e = new Tlv_t17e();
        ///*Tlv_t182*/
        //$t182 = new Tlv_t182();
        ///*Tlv_t183*/
        //$t183 = new Tlv_t183();
        ///*Tlv_t186*/
        //$t186 = new Tlv_t186();
        ///*Tlv_t402*/
        //$t402 = new Tlv_t402();
        ///*Tlv_t403*/
        //$t403 = new Tlv_t403();
        //

        /*byte[]*/
        $t102_data = null;
        /*byte[]*/
        $t10b_data = null;
        /*byte[]*/
        $t11c_data = null;
        /*byte[]*/
        $t120_data = null;
        /*byte[]*/
        $t121_data = null;
        /*byte[]*/
        $t103_data = null;
        /*byte[]*/
        $t169_data = null;//todo add it
        /*byte[]*/
        $openid_data = null;
        /*byte[]*/
        $t125_openkey_data = null;
        /*tlv_t133*/
        $t133 = new Tlv_t133();
        /*tlv_t134*/
        $t134 = new Tlv_t134();
        /*tlv_t136*/
        $t136 = new Tlv_t136();
        if ($this->_cmd == 2064 && $this->_sub_cmd == 9) {
            $flowid = 0;
        } elseif ($this->_cmd == 2064 && ($this->_sub_cmd == 10 || $this->_sub_cmd == 11)) {
            $flowid = 1;
        } elseif ($this->_cmd == 2064 && $this->_sub_cmd == 2) {
            $flowid = 2;
        } elseif ($this->_cmd == 2064 && $this->_sub_cmd == 4) {
            $flowid = 3;
        } elseif ($this->_cmd == 2064 && $this->_sub_cmd == 6) {
        //} elseif ($this->_cmd == 2064 && $this->_sub_cmd == 13) { todo add it
            $flowid = 4;
        } elseif ($this->_cmd == 2064 && $this->_sub_cmd == 7) {
        //} elseif ($this->_cmd == 2064 && $this->_sub_cmd == 15) { todo add it
            $flowid = 5;
        } elseif ($this->_cmd == 2064 && $this->_sub_cmd == 8) {
        //} elseif ($this->_cmd == 2064 && $this->_sub_cmd == 7) { todo add it
            $flowid = 6;
        } elseif ($this->_cmd == 2064 && $this->_sub_cmd == 18) {
            $flowid = 7;
        } elseif ($this->_cmd != 2064 || $this->_sub_cmd != 13) {
            return -1012;
        } else {
            $flowid = 7;
        }

        if ($len < 5) {
            return -1009;
        }

        $ret  = null;
        $type = $this->get_response_ret_code($in, $pos + 2);
        $this->set_err_msg(null);
        //util->LOGD(getClass()->getName(), "get_response_body type=" + type);
        $pos += 5;
        $this->_g->_t150 = null;
        switch ($type) {
            case 0: //util->f14644W
                if ($flowid == 1 || ($this->get_last_flowid() == 1 && $flowid == 4)) {
                    if ($this->_g->_master_tgt_key == null) {
                        return -1006;//util->E_NO_TGTKEY;
                    }
                    if ($t150->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0) {
                        $this->_g->_t150 = $t150;
                    }
                    //todo add it
                    //if ($t161->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0) {
                    //    $this->parse_t161($t161)
                    //}
                    $ret = $t119->get_tlv($in, $pos, ($this->_pos - $pos) - 1, $this->_g->_master_tgt_key);
                    //util->LOGD("decrypt key=", util->buf_to_string($this->_g->_master_tgt_key));
                } elseif ($flowid == 2) {
                    if ($this->get_last_flowid() == 3) {
                        if ($t113->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0) {
                            $this->_g->_t113 = $t113;
                            $this->_g->_uin  = $this->_g->_t113->get_uin();
                            $this->_g->put_account($this->_g->_name, $this->_g->_uin);
                        }
                        if ($t104->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0) {
                            $this->_g->_t104 = $t104;
                        }
                        $ret = $type;
                        break;
                    }
                    if ($t150->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0) {
                        $this->_g->_t150 = $t150;
                    }
                    //todo add it
                    //if ($t161->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0) {
                    //    $this->parse_t161($t161)
                    //}
                    $ret = $t119->get_tlv($in, $pos, ($this->_pos - $pos) - 1, $this->_g->_key_tgtgt);
                } elseif ($flowid == 3 || ($this->get_last_flowid() == 3 && $flowid == 4)) {
                //todo add it
                //elseif ($flowid == 3 || $flowid == 7 || ($this->get_last_flowid() == 3 && $flowid == 4)) {
                    $ret = $t113->get_tlv($in, $pos, $this->_pos - $pos);
                    if ($ret >= 0) {
                        $this->_g->_t113 = $t113;
                        $this->_g->_uin  = $this->_g->_t113->get_uin();
                        $this->_g->put_account($this->_g->_name, $this->_g->_uin);
                        $ret = $t104->get_tlv($in, $pos, $this->_pos - $pos);
                        if ($ret >= 0) {
                            $this->_g->_t104 = $t104;
                            $ret             = $type;
                            break;
                        }
                    }
                } else {
                    if ($t150->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0) {
                            $this->_g->_t150 = $t150;
                    }
                    //todo add it
                    //if ($t161->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0) {
                    //    $this->parse_t161($t161)
                    //}
                    $ret = $t119->get_tlv($in, $pos, ($this->_pos - $pos) - 1, $this->_g->_key_tgtgt);
                }


                if ($ret < 0) {
                    //util->LOGD("119 can not decrypt");
                    break;
                }
                $in1 = $t119->get_data();
                $tl  = $in1->length;
                if ($t149->get_tlv($in1, 2, $tl) > 0) {
                    $this->show_alert_dialog($t149);
                }
                if ($t130->get_tlv($in1, 2, $tl) > 0) {
                    $this->_g->set_time_ip($t130->get_time(), $t130->get_ipaddr());
                }
                $ret = $t10d->get_tlv($in1, 2, $tl);
                $ret = $t10e->get_tlv($in1, 2, $tl);
                $ret = $t10a->get_tlv($in1, 2, $tl);
                $ret = $t114->get_tlv($in1, 2, $tl);
                $ret = $t11a->get_tlv($in1, 2, $tl);
                if ($ret >= 0) {
                    if ($t103->get_tlv($in1, 2, $tl) >= 0) {
                        $t103_data = $t103->get_data();
                    }
                    if ($t108->get_tlv($in1, 2, $tl) >= 0) {
                        $this->_g->_ksid = $t108->get_data();
                    }
                    if ($t102->get_tlv($in1, 2, $tl) >= 0) {
                        $t102_data = $t102->get_data();
                    }
                    if ($t10b->get_tlv($in1, 2, $tl) >= 0) {
                        $t10b_data = $t10b->get_data();
                    }
                    if ($t11c->get_tlv($in1, 2, $tl) >= 0) {
                        //LOGD("t11c ret=", $ret);
                        $t11c_data = $t11c->get_data();
                        //LOGD("t11c ret=", util->buf_to_string(t11c_data));
                    }
                    if ($t120->get_tlv($in1, 2, $tl) >= 0) {
                        $t120_data = $t120->get_data();
                    }
                    if ($t121->get_tlv($in1, 2, $tl) >= 0) {
                        $t121_data = $t121->get_data();
                    }
                    if ($t125->get_tlv($in1, 2, $tl) >= 0) {
                        $openid_data       = $t125->get_openid();
                        $t125_openkey_data = $t125->get_openkey();
                    }
                    // LOGI(
                    //"tgt len:" + util->buf_len(t10a->get_data()) +
                    // " tgt_key len:" + util->buf_len(t10d->get_data()) +
                    // " st len:" + util->buf_len(t114->get_data()) +
                    // " st_key len:" + util->buf_len(t10e->get_data()) +
                    // " stwx_web len:" + util->buf_len(t103_data) +
                    // " a8 len:" + util->buf_len(t102_data) +
                    // " a5 len:" + util->buf_len(t10b_data) +
                    // " lskey len:" + util->buf_len(t11c_data) +
                    // " skey len:" + util->buf_len(t120_data) +
                    // " sig64 len:" + util->buf_len(t121_data) +
                    // " openid len:" + util->buf_len(openid_data) +
                    // " openkey len:" + util->buf_len(t125_openkey_data),
                    //            $this->_g->_context, $this->_g->_uin, 1);
                    //todo add it
                    //if ($t168->get_tlv($in1, 2, $tl) >= 0) {
                    //    if($name = $this->_g->get_userAccount($this->_g->_uin)){
                    //        $this->_g->put_account($name, $this->_g->_uin, $tlv_t186->getPwdflag());
                    //    }
                    //}
                    if ($t169->get_tlv($in1, 2, $tl) >= 0) {
                        $this->on_return_A1($t169->get_data());
                        //util->LOGD("t169 ret=", util->buf_to_string(t169->get_data()));
                    } else {
                        $this->on_return_A1(null);
                    }
                    $reserve_uin_info = [];
                    if ($t167->get_tlv($in1, 2, $tl) >= 0) {
                        $reserve_uin_info[0] = $t167->get_img_type();
                        $reserve_uin_info[1] = $t167->get_img_format();
                        $reserve_uin_info[2] = $t167->get_img_url();
                        //LOGI("type:" + util->buf_to_string(reserve_uin_info[0]) + " format:" + util->buf_to_string(reserve_uin_info[1]) + " url:" + new String(reserve_uin_info[2]));
                        //todo add it
                        //$this->_g.put_account($reserve_uin_info, $this->_g->_uin, $tlv_t186->getPwdflag());
                    }
                    //byte[][] reserve = (byte[][]) Array.newInstance(Byte->TYPE, new int[]{9, 0});
                    //for ($i = 0; $i < 9;$i++) {
                    $reserve = [];//8
                    //}
                    if ($t133->get_tlv($in1, 2, $tl) >= 0) {
                        $reserve[0] = $t133->get_data();
                    }
                    if ($t134->get_tlv($in1, 2, $tl) >= 0) {
                        $reserve[1] = $t134->get_data();
                    }
                    if ($t136->get_tlv($in1, 2, $tl) >= 0) {
                        $reserve[2] = $t136->get_data();
                    }
                    $ret1 = $t10c->get_tlv($in1, 2, $tl);
                    if ($t106->get_tlv($in1, 2, $tl) >= 0 && $ret1 >= 0) {
                        //util->LOGD("update A1 from server:", util->buf_to_string(t106->get_data()));
                        //util->LOGD("key:", util->buf_to_string(t10c->get_data()));
                        $this->_g->_key_tgtgt  = $t10c->get_data();
                        $this->_g->_encrypt_a1 = $this->encrypt_a1($t106->get_data());
                        //util->LOGD("key2:", util->buf_to_string($this->_g->_key_tgtgt));
                        $reserve[3] = $this->_g->_encrypt_a1->clone();
                    }
                    if ($t132->get_tlv($in1, 2, $tl) >= 0) {
                        $reserve[4]  = $t132->get_access_token();
                        $openid_data = $t132->get_openid();
                    }
                    if ($t143->get_tlv($in1, 2, $tl) >= 0) {
                        $reserve[5] = $t143->get_data();
                    }
                    if ($t305->get_tlv($in1, 2, $tl) >= 0) {
                        $reserve[6] = $t305->get_data();
                    }
                    if ($t164->get_tlv($in1, 2, $tl) >= 0) {
                        $reserve[7] = $t164->get_data();
                    }
                    if ($t16a->get_tlv($in1, 2, $tl) >= 0) {
                        $reserve[8] = $t16a->get_data();
                    }

                    //todo add it
                    //if ($t106->get_tlv($in1, 2, $tl) >= 0 && $ret1 >= 0) {
                    //    //util->LOGD("update A1 from server:", util->buf_to_string(t106->get_data()));
                    //    //util->LOGD("key:", util->buf_to_string(t10c->get_data()));
                    //    $this->_g->_key_tgtgt  = $t10c->get_data();
                    //    $this->_g->_encrypt_a1 = $this->encrypt_a1($t106->get_data());
                    //    //util->LOGD("key2:", util->buf_to_string($this->_g->_key_tgtgt));
                    //    $reserve[0] = $this->_g->_encrypt_a1->clone();
                    //}
                    //if ($t16a->get_tlv($in1, 2, $tl) >= 0) {
                    //    $reserve[1]  = $t16a->get_data();
                    //}
                    //if($async_context->_sec_guid_flag){
                    //    $reserve[2]  = $async_context->_G;
                    //    $reserve[3]  = $async_context->_dpwd;
                    //    $reserve[4]  = $async_context->_t403->get_data();
                    //}
                    //end

                    //todo add it
                    //if ($t136->get_tlv($in1, 2, $tl) >= 0) {
                    //    $vkey[0] = $t136->get_data();
                    //}
                    //if ($t132->get_tlv($in1, 2, $tl) >= 0) {
                    //    $vkey[1]  = $t132->get_access_token();
                    //    $openid_data = $t132->get_openid();
                    //}
                    //if ($t143->get_tlv($in1, 2, $tl) >= 0) {
                    //    $vkey[2] = $t143->get_data();
                    //}
                    //if ($t305->get_tlv($in1, 2, $tl) >= 0) {
                    //    $vkey[3] = $t305->get_data();
                    //}
                    //if ($t164->get_tlv($in1, 2, $tl) >= 0) {
                    //    $vkey[4] = $t164->get_data();
                    //}
                    //if ($t171->get_tlv($in1, 2, $tl) >= 0) {
                    //    $vkey[5] = $t171->get_data();
                    //}
                    //if ($t16c->get_tlv($in1, 2, $tl) >= 0) {
                    //    $vkey[6] = $t16c->get_data();
                    //}
                    //if ($t16d->get_tlv($in1, 2, $tl) >= 0) {
                    //    $vkey[7] = $t16d->get_data();
                    //}
                    //if($t11f->get_tlv($t104, 2, $tl)){
                    //    $l1 = $t11f->get_tk_pri();
                    //}



                    // util->LOGI(
                    // "new_st len:" + util->buf_len(reserve[0]) +
                    // " net_st_key len:" + util->buf_len(reserve[1]) +
                    // " vkey len:" + util->buf_len(reserve[2]) +
                    // " encrypt_a1 len:" + util->buf_len(reserve[3]) +
                    // " openid len:" + util->buf_len(openid_data) +
                    // " access_token len:" + util->buf_len(reserve[4]) +
                    // " d2 len:" + util->buf_len(reserve[5]) +
                    // " d2_key len:" + util->buf_len(reserve[6]) +
                    // " sid len:" + util->buf_len(reserve[7]) +
                    // " no_pic_sig len:" + util->buf_len(reserve[8]),
                    //            $this->_g->_context, $this->_g->_uin, 1);
                    if ($t11f->get_tlv($in1, 2, $tl) >= 0) {
                        if ($this->_g->_tk_time_out != -1) {
                            $tk_expire = $this->_g->_tk_time_out;
                        }
                        $app_pri = $t11f->get_tk_pri();
                        //util->LOGD("tk_expire=" + new Long(tk_expire)->toString());
                    }
                    $reserve_expire = new long[7];
                    $ret            = 2;
                    while (true) {
                        $ret = $t138->get_tlv($in1, $ret, $tl);
                        if ($ret < 0) {
                            if ($a2_expire < $tk_expire) {
                                $a2_expire = $tk_expire;
                            }
                            //util->LOGI(
                            //"appid:" + $this->_g->_appid +
                            // " app_pri:" + app_pri +
                            // " tk_expire:" + tk_expire +
                            // " a2_expire:" + a2_expire +
                            // " lskey_expire:" + reserve_expire[0] +
                            // " skey_expire:" + reserve_expire[1] +
                            // " vkey_expire:" + reserve_expire[2] +
                            // " a8_expire:" + reserve_expire[3] +
                            // " stweb_expire:" + reserve_expire[4] +
                            // " d2_expire:" + reserve_expire[5] +
                            // " sid_expire:" + reserve_expire[6],
                            //            $this->_g->_context, $this->_g->_uin, 1);
                            $ret = $this->_g->put_siginfo($this->_g->_uin,
                                                          $this->_g->_appid,
                                                          $app_pri,
                                                          $this->request_global->get_cur_time(),
                                                          $this->request_global->get_cur_time() + $tk_expire,
                                                          $this->request_global->get_cur_time() + $a2_expire,
                                                          $t11a->get_face(),
                                                          $t11a->get_age(),
                                                          $t11a->get_gander(),
                                                          $t11a->get_nick(),
                                                          $reserve_uin_info,
                                                          $t10a->get_data(),
                                                          $t10d->get_data(),
                                                          $t114->get_data(),
                                                          $t10e->get_data(),
                                                          $t103_data,
                                                          $t10b_data,
                                                          $t102_data,
                                                          $t11c_data,
                                                          $t120_data,
                                                          $t121_data,
                                                          $openid_data,
                                                          $t125_openkey_data,
                                                          $reserve,
                                                          $reserve_expire);
                            //todo add it
                            //$ret = $this->_g->put_siginfo($this->_g->_uin,
                            //                              $async_context->_sappid,
                            //                              $encrypt_a1,
                            //                              //$this->_g->_appid,
                            //                              $async_context->_appid,
                            //                              $app_pri,
                            //                              $this->request_global->get_cur_time(),
                            //                              $this->request_global->get_cur_time() + $tk_expire,
                            //                              $this->request_global->get_cur_time() + $a2_expire,
                            //                              $t11a->get_face(),
                            //                              $t11a->get_age(),
                            //                              $t11a->get_gander(),
                            //                              $t11a->get_nick(),
                            //                              //$reserve_uin_info, $t10a->get_data(),
                            //                              $t169,
                            //                              $t10a->get_data(),
                            //                              $t10d->get_data(),
                            //                              $t114->get_data(),
                            //                              $t10e->get_data(),
                            //                              $t103_data,
                            //                              $t10b_data,
                            //                              $t102_data,
                            //                              $t11c_data,
                            //                              $t120_data,
                            //                              $t121_data,
                            //                              $openid_data,
                            //                              $t125_openkey_data,
                            //                              $vkey,
                            //                              //$reserve_expire
                            //                              $async_context->_login_bitmap
                            //);
                            if ($ret != 0) {
                                //ErrMsg errMsg = new ErrMsg();
                                //errMsg->setMessage("手机存储异常，请删除帐号重试。");
                                //set_err_msg(errMsg);
                                //util->LOGI("put_siginfo fail,ret=" + ret, $this->_g->_context, $this->_g->_uin, 1);
                                throw new \Exception("手机存储异常，请删除帐号重试。");
                                break;
                            }
                            if ($flowid != 1) {
                                $this->_g->save_last_login_info($this->_g->_last_login_account);
                            }
                            $ret = 2;
                            while (true) {
                                $ret = $t11d->get_tlv($in1, $ret, $tl);
                                if ($ret < 0) {
                                    $ret = 0;
                                    break;
                                }
                                $this->_g->put_siginfo($this->_g->_uin, $t11d->get_appid(),
                                                       $this->request_global->get_cur_time(),
                                                       $this->request_global->get_cur_time() + $tk_expire,
                                                       $t11d->get_st(),
                                                       $t11d->get_stkey());
                            }
                        } else {
                            if ($t138->get_a2_chg_time() != 0) {
                                $a2_expire = $t138->get_a2_chg_time();
                                //util->LOGD("a2_expire=" + new Long(a2_expire)->toString());
                            }
                            if ($t138->get_lskey_chg_time() != 0) {
                                $reserve_expire[0] = $t138->get_lskey_chg_time();
                            } else {
                                $reserve_expire[0] = 1641600;
                            }
                            //util->LOGD("lskey_expire=" + new Long(reserve_expire[0])->toString());
                            if ($t138->get_skey_chg_time() != 0) {
                                $reserve_expire[1] = $t138->get_skey_chg_time();
                            } else {
                                $reserve_expire[1] = 2880;
                            }
                            //util->LOGD("skey_expire=" + new Long(reserve_expire[1])->toString());
                            if ($t138->get_vkey_chg_time() != 0) {
                                $reserve_expire[2] = $t138->get_vkey_chg_time();
                            } else {
                                $reserve_expire[2] = 1728000;
                            }
                            //util->LOGD("vkey_expire=" + new Long(reserve_expire[2])->toString());
                            if ($t138->get_a8_chg_time() != 0) {
                                $reserve_expire[3] = $t138->get_a8_chg_time();
                            } else {
                                $reserve_expire[3] = 72000;
                            }
                            //util->LOGD("a8_expire=" + new Long(reserve_expire[3])->toString());
                            if ($t138->get_stweb_chg_time() != 0) {
                                $reserve_expire[4] = $t138->get_stweb_chg_time();
                            } else {
                                $reserve_expire[4] = 6000;
                            }
                            //util->LOGD("stweb_expire=" + new Long(reserve_expire[4])->toString());
                            if ($t138->get_d2_chg_time() != 0) {
                                $reserve_expire[5] = $t138->get_d2_chg_time();
                            } else {
                                $reserve_expire[5] = 1728000;
                            }
                            //util->LOGD("d2_expire=" + new Long(reserve_expire[5])->toString());
                            if ($t138->get_sid_chg_time() != 0) {
                                $reserve_expire[6] = $t138->get_sid_chg_time();
                            } else {
                                $reserve_expire[6] = 1728000;
                            }
                            //util->LOGD("sid_expire=" + new Long(reserve_expire[6])->toString());
                        }
                    }
                }
                break;
            case 1: //util->S_PWD_WRONG
                $this->get_err_msg($in, $pos, ($this->_pos - $pos) - 1);
                $ret = $type;
                break;
            case 2: //util->S_GET_IMAGE
                $ret = $t104->get_tlv($in, $pos, ($this->_pos - $pos) - 1);
                if ($ret >= 0) {
                    $this->_g->_t104 = $t104;
                    $ret             = $t105->get_tlv($in, $pos, ($this->_pos - $pos) - 1);
                    if ($ret >= 0) {
                        $this->_g->_t105 = $t105;
                        if ($t165->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0) {
                            $this->_g->_t165 = $t165;
                        } else {
                            $this->_g->_t165 = new tlv_t165();
                        }
                        if ($flowid == 3) {
                            $this->_g->_getuin_need_image = 1;
                        }
                        $this->get_err_msg($in, $pos, ($this->_pos - $pos) - 1);
                        $ret = $type;
                        break;
                    }
                }
                break;
            case 3: //util->S_DELAY
                $ret = $t104->get_tlv($in, $pos, ($this->_pos - $pos) - 1);
                if ($ret >= 0) {
                    $this->_g->_t104 = $t104;
                    $ret             = $t122->get_tlv($in, $pos, ($this->_pos - $pos) - 1);
                    if ($ret >= 0) {
                        $this->_g->_t122 = $t122;
                        $this->get_err_msg($in, $pos, ($this->_pos - $pos) - 1);
                        $ret = $type;
                        break;
                    }
                }
                break;
            case 16: //RemoteSync->TCC_SYNC_CRYPT_XXTEA
                $ret = $t130->get_tlv($in, $pos, ($this->_pos - $pos) - 1);
                if ($ret >= 0) {
                    $this->_g->set_time_ip($t130->get_time(), $t130->get_ipaddr());
                    $this->get_err_msg($in, $pos, ($this->_pos - $pos) - 1);
                    $ret = $type;
                    break;
                }
                break;
            case 160: //util->S_GET_SMS_CHECK
                $ret = $t104->get_tlv($in, $pos, ($this->_pos - $pos) - 1);
                if ($ret >= 0) {
                    $this->_g->_t104 = $t104;
                    $ret             = $t126->get_tlv($in, $pos, ($this->_pos - $pos) - 1);
                    if ($ret >= 0) {
                        $this->_g->_t126 = $t126;
                        $ret             = $t129->get_tlv($in, $pos, ($this->_pos - $pos) - 1);
                        if ($ret >= 0) {
                            $this->_g->_t129 = $t129;
                            $this->get_err_msg($in, $pos, ($this->_pos - $pos) - 1);
                            $ret = $type;
                            break;
                        }
                    }
                }
                break;
            // todo add it
            //case 174:
            //    $ret = $t174->get_tlv($in, $pos, ($this->_pos - $pos) - 1);
            //    if ($ret >= 0) {
            //        $this->_g->_t174 = $t174;
            //        $ret = $type;
            //        break;
            //    }
            //    break;
            case 176:
                $this->get_err_msg($in, $pos, ($this->_pos - $pos) - 1);
                $ret = $type;
                $this->_g->remove_account($this->_g->_name);
                break;
            // todo add it
            //case 178:
            //    if ($t178->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0) {
            //        $async_context->_devlock_info->CountryCode          = $tlv_t178->get_country_code();
            //        $async_context->_devlock_info->Mobile               = $tlv_t178->get_mobile();
            //        $async_context->_devlock_info->MbItemSmsCodeStatus  = $tlv_t178->get_smscode_status();
            //        $async_context->_devlock_info->AvailableMsgCount    = $tlv_t178->get_available_msg_cnt();
            //        $async_context->_devlock_info->TimeLimit            = $tlv_t178->get_time_limit();
            //        break;
            //    }
            //    if ($t179->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0) {
            //        $async_context->_devlock_info->UnionVerifyUrl = $tlv_t179->get_verify_url();
            //    }
            //    if ($t17d->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0)
            //    {
            //        $async_context->_devlock_info->MbGuideType      =   $tlv_t17d->get_mb_guide_type();
            //        $async_context->_devlock_info->MbGuideMsg       =   $tlv_t17d->get_mb_guide_msg();
            //        $async_context->_devlock_info->MbGuideInfoType  =   $tlv_t17d->get_mb_guide_info_type();
            //        $async_context->_devlock_info->MbGuideInfo      =   $tlv_t17d->get_mb_guide_info();
            //    }
            //    if ($t17e->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0) {
            //        $async_context->_devlock_info->VerifyReason = $t17e->get_data());
            //    }
            //    if ($t402->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0)
            //    {
            //        $async_context->_t402 = $tlv_t402;
            //    }
            //    if ($t182->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0)
            //    {
            //        $async_context->_smslogin_msgcnt    = $tlv_t182->getMsgCnt();
            //        $async_context->_smslogin_timelimit = $tlv_t182->getTimeLimit();
            //    }
            //    if ($t183->get_tlv($in, $pos, ($this->_pos - $pos) - 1) >= 0)
            //    {
            //        $async_context->_msalt      = $t183->getMsalt();
            //    }
            //    break;
            default:
                $this->get_err_msg($in, $pos, ($this->_pos - $pos) - 1);
                $ret = $type;
                break;
        }
        if ($ret == 9 || $ret == 10 || $ret == 161 || $ret == 162 || $ret == 164 || $ret == 165 || $ret == 166 || $ret == 154 || ($ret >= 128 && $ret <= 143)) {
        // todo add it
        //if ($ret == 10 || $ret == 161 || $ret == 162 || $ret == 164 || $ret == 165 || $ret == 166 || $ret == 154 || ($ret >= 128 && $ret <= 143)) {
            $ret = -1000;
        }
        if ($type == 0 && $ret != 0) {
            $this->set_err_msg(new ErrMsg());
        }
        if (!($flowid == 2 || $flowid == 4 || $flowid == 5 || $flowid == 6)) {
        //if (!($flowid == 2 || $flowid == 6 || $flowid == 7)) { todo add it
            $this->set_last_flowid($flowid);
        }
        return $ret;
    }
}
