<?php


namespace botmm\GradeeBundle\Oicq\Tlv;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamOutputBuffer;
use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Cypher\MD5;
use botmm\GradeeBundle\Oicq\Tools\Util;

class Tlv_t106 extends Tlv_t
{

    protected $_SSoVer = Util::SSO_VERSION;

    protected $_TGTGTVer = Util::TGTGTVer;

    protected $_t106_body_len;

    public function __construct()
    {
        parent::__construct();
        $this->_cmd      = 262;
        $this->_SSoVer   = Util::SSO_VERSION;
        $this->_TGTGTVer = Util::TGTGTVer;

        if ($this->_SSoVer <= 2 && $this->_TGTGTVer == 1) {
            $this->_t106_body_len = 69;
        } elseif ($this->_SSoVer == 3 && $this->_TGTGTVer == 2) {
            $this->_t106_body_len = 90;
        } elseif ($this->_SSoVer == 5 && $this->_TGTGTVer == 3) {
            $this->_t106_body_len = 98 + 2; //98 + 2 + n;
        } elseif ($this->_SSoVer == 5 && $this->_TGTGTVer == 4) {
            $this->_t106_body_len = 98 + 2 + 15; //98 + 2 + n; 多加一点
        }
    }

    /**
     * @param long|string   $appid
     * @param long|string   $subAppId ssoVer==5 537042771
     * @param int           $client_ver
     * @param long|string   $uin
     * @param byte[]|string $init_time
     * @param byte[]|string $client_ip
     * @param byte|string   $seve_pwd
     * @param byte[]|string $md5
     * @param byte[]|string $TGTGT    3 ssover 5
     * @param int           $readflg
     * @param byte[]|string $guid
     * @return mixed
     */
    public function get_tlv_106(
        $appid,
        $subAppId,
        $client_ver,
        $uin,
        $init_time,
        $client_ip,
        $seve_pwd,
        $md5,
        //$uin,
        //$mUserAccount,
        $TGTGT,
        $readflg,
        $guid
    ) {
        if (util::SSO_VERSION <= 2) {
            return $this->_getSSOV2($appid, $subAppId, $client_ver, $uin, $init_time, $client_ip, $seve_pwd, $md5,
                                    $TGTGT,
                                    $readflg, $guid);
        } elseif ($this->_SSoVer == 3) {
            return $this->_getSSOV3($appid, $subAppId, $client_ver, $uin, $init_time, $client_ip, $seve_pwd, $md5,
                                    $TGTGT,
                                    $readflg, $guid);
        } elseif ($this->_SSoVer == 5) {
            return $this->_getSSOV5($appid, $subAppId, $client_ver, $uin, $init_time, $client_ip, $seve_pwd, $md5,
                                    $TGTGT,
                                    $readflg, $guid);
        }

    }

    private function _getSSOV2(
        $appid,
        $subAppId,
        $client_ver,
        $uin,
        $init_time,
        $client_ip,
        $seve_pwd,
        $md5,
        $TGTGT,
        $readflg,
        $guid
    ) {
        $body = new Buffer($this->_t106_body_len);
        $p    = 0;
        $body->writeInt16BE($this->_TGTGTVer, $p);
        $p += 2;
        $body->writeInt32BE(mt_rand(), $p);
        $p += 4;
        $body->writeInt32BE($this->_SSoVer, $p);
        $p += 4;
        $body->writeInt32BE($appid, $p);
        $p += 4;
        $body->writeInt32BE($client_ver, $p);
        $p += 4;
        $body->writeInt64BE($uin, $p);
        $p += 8;
        $body->write($init_time, $p, 4);
        $p += 4;
        $body->write($client_ip, $p, 4);
        $p += 4;
        $body->writeInt8($seve_pwd, $p);
        $p++;
        $body->write($md5, $p, 16);
        $p += 16;
        $body->write($TGTGT, $p, 16);
        $p += 16;
        $s2 = new Buffer(24);
        $s2->write($md5, 0);
        $s2->writeInt64BE($uin, 16);
        $body                 = Cryptor::encrypt($body, 0, $p, MD5::toMD5Byte($s2));
        $this->_t106_body_len = strlen($body);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t106_body_len);
        $this->set_length();
        return $this->get_buf();
    }

    private function _getSSOV3(
        $appid,
        $subAppId,
        $client_ver,
        $uin,
        $init_time,
        $client_ip,
        $seve_pwd,
        $md5,
        $TGTGT,
        $readflg,
        $guid
    ) {
        $body = new Buffer($this->_t106_body_len);
        $p    = 0;
        $body->writeInt16BE($this->_TGTGTVer, $p);
        $p += 2;
        $body->writeInt32BE(mt_rand(), $p);
        $p += 4;
        $body->writeInt32BE($this->_SSoVer, $p);
        $p += 4;
        $body->writeInt32BE($appid, $p);
        $p += 4;
        $body->writeInt32BE($client_ver, $p);
        $p += 4;
        $body->writeInt64BE($uin, $p);
        $p += 8;
        $body->write($init_time, $p, 4);
        $p += 4;
        $body->write($client_ip, $p, 4);
        $p += 4;
        $body->writeInt8($seve_pwd, $p);
        $p++;
        $body->write($md5, $p, 16);
        $p += 16;
        $body->write($TGTGT, $p, 16);
        $p += 16;
        $body->writeInt32BE(0, $p);
        $p += 4;
        $body->writeInt8($readflg, $p);
        $p++;
        if ($guid == null || strlen($guid) <= 0) {
            $guid = new Buffer(16);
            $guid->writeInt32BE(mt_rand(), 0);
            $guid->writeInt32BE(mt_rand(), 4);
            $guid->writeInt32BE(mt_rand(), 8);
            $guid->writeInt32BE(mt_rand(), 12);
        }
        $body->write($guid, $p, 16);
        $p += 16;
        $s2 = new Buffer(24);
        $s2->write($md5, 0);
        $s2->writeInt64BE($uin, 16);
        $body                 = Cryptor::encrypt($body, 0, $p, md5($s2->read(0, 24), true));
        $this->_t106_body_len = strlen($body);
        $this->fill_head($this->_cmd);
        $this->fill_body($body, $this->_t106_body_len);
        $this->set_length();
        return $this->get_buf();

    }

    /**
     * <p>
     * 00 03
     * 18 76 f8 51
     * 00 00 00 05
     * 00 00 00 00
     * 00 00 00 00
     * 00 00 00 00 00 2b c0 65
     * 31 34 38 35
     * 30 00 00 00
     * 01
     * 1e 1b 28 d6 9e bb 95 fd 04 06 24 bc e5 2b 68 3c
     * 37 74 bc b1 35 5c 65 d4 1a fd 0b 14 20 62 7d 7e
     * 00 00 00 00
     * 01
     * 46 60 1e d3 c6 24 16 bf ca a2 9e 9e b8 9a d2 4e
     * 00 00 00 00
     * 00 00 00 01
     * 00 00
     * </p>
     *
     * @param $appid
     * @param $subAppId
     * @param $client_ver
     * @param $uin
     * @param $init_time
     * @param $client_ip
     * @param $seve_pwd
     * @param $md5
     * @param $TGTGT
     * @param $readflg
     * @param $guid
     * @return mixed
     */
    private function _getSSOV5(
        $appid,
        $subAppId,
        $client_ver,
        $uin,
        $init_time,
        $client_ip,
        $seve_pwd,
        $md5,
        $TGTGT,
        $readflg,
        $guid
    ) {
        $userAccount = strval($uin);
        $body        = new StreamOutputBuffer(new Buffer());
        $body->writeInt16BE($this->_TGTGTVer); //can be 4
        $body->writeInt32BE(mt_rand());
        $body->writeInt32BE($this->_SSoVer);
        $body->writeInt32BE($appid);
        $body->writeInt32BE($client_ver);
        $body->writeInt64BE($uin);
        $body->writeInt32BE($init_time);
        $body->write($client_ip, 4);
        $body->writeInt8($seve_pwd);
        $body->write($md5, 16);
        $body->write($TGTGT, 16);
        $body->writeInt32BE(0);
        $body->writeInt8($readflg);
        if ($guid == null || strlen($guid) <= 0) {
            $guid = new Buffer(16);
            $guid->writeInt32BE(mt_rand(), 0);
            $guid->writeInt32BE(mt_rand(), 4);
            $guid->writeInt32BE(mt_rand(), 8);
            $guid->writeInt32BE(mt_rand(), 12);
        }
        $body->write($guid, 16);
        //sso 5
        $body->writeInt32BE($subAppId);
        $body->writeInt32BE(1); //1
        $body->writeInt16BE(strlen($userAccount)); //uin长度
        $body->write($userAccount);
        $body->writeInt16BE(0);//imei length
        //$body->write($imei);//imei
        //end sso 5
        $s2 = new Buffer(24);
        $s2->write($md5, 0);
        $s2->writeInt64BE($uin, 16);
        $encryptedBody        = Cryptor::encrypt($body->getBytes(), 0, $body->getLength(), md5($s2->read(0, 24), true));
        $this->_t106_body_len = strlen($encryptedBody);
        $this->fill_head($this->_cmd);
        $this->fill_body($encryptedBody, $this->_t106_body_len);
        $this->set_length();
        return $this->get_buf();
    }
}
