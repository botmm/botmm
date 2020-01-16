<?php


namespace botmm\GradeeBundle\Oicq\Pack;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamOutputBuffer;
use botmm\common\qq_info;
use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Tools\Hex;
use botmm\PlatformBundle\PlatformInfo\PlatformInfo;
use botmm\PlatformBundle\PlatformInfo\QqInfo;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoginPack
{
    use ContainerAwareTrait;

    /**
     * @var Buffer
     */
    public $buffer;

    public $written = 0;

    public $cmd = 0x0810;

    /**
     * @var PlatformInfo
     */
    public $platformInfo;
    /**
     * @var QqInfo
     */
    public $qq;


    public $isSecond;


    public $ssoSeq;

    public function __construct($platformInfo, $qq)
    {
        $this->platformInfo = $platformInfo;
        $this->ssoSeq       = $this->platformInfo->runtime->getSsoSeq();
        $this->qq           = $qq;

        $this->buffer = new Buffer(32);
    }

    public function pack($simple = false)
    {
        $this->qq->time = time();

        $wupBuffer = $this->startPack();

        $sendSsoMsg = $this->container->get('botmm_gradee.pack.make_login_send_sso_msg');

        if (!$simple) {
            $msg = $sendSsoMsg->pack(
                $wupBuffer,
                ""
            );
        } else {
            $msg = $sendSsoMsg->packSimple(
                $wupBuffer,
                ""
            );
        }

        return $msg;
    }

    public function startPack()
    {
        $encrypt = $this->cryptOicqRequestBuffer();

        $packed = $this->oicqRequestBuffer($this->cmd,
                                           $encrypt,
                                           $this->qq->randKey,
                                           $this->qq->pubKey);
        return $packed;

    }

    private function cryptOicqRequestBuffer()
    {
        $buffer      = new Buffer();
        $loginBuffer = new StreamOutputBuffer($buffer);
        $loginBuffer->writeHex("00 09");//sub_cmd
        if ($this->qq->rollbackSig) {
            $loginBuffer->writeInt16BE(0x19); //tlv 个数
        } else {
            $loginBuffer->writeInt16BE(0x18); //tlv 个数
        }
        $loginBuffer->write($this->get_tlv18());
        $loginBuffer->write($this->get_tlv1());
        $loginBuffer->write($this->get_tlv106());
        $loginBuffer->write($this->get_tlv116());
        $loginBuffer->write($this->get_tlv100());
        $loginBuffer->write($this->get_tlv107());
        $loginBuffer->write($this->get_tlv108());
        $loginBuffer->write($this->get_tlv142());
        $loginBuffer->write($this->get_tlv144());
        $loginBuffer->write($this->get_tlv145());
        $loginBuffer->write($this->get_tlv147());
        $loginBuffer->write($this->get_tlv154());
        $loginBuffer->write($this->get_tlv141());
        $loginBuffer->write($this->get_tlv8());
        $loginBuffer->write($this->get_tlv511());
        if ($this->qq->rollbackSig) {
            $loginBuffer->write($this->get_tlv172());
        }
        $loginBuffer->write($this->get_tlv187());
        $loginBuffer->write($this->get_tlv188());
        $loginBuffer->write($this->get_tlv194());
        $loginBuffer->write($this->get_tlv191());
        $loginBuffer->write($this->get_tlv202());
        $loginBuffer->write($this->get_tlv177());
        $loginBuffer->write($this->get_tlv516());
        $loginBuffer->write($this->get_tlv521());
        $loginBuffer->write($this->get_tlv525());
        //$loginBuffer->write($this->get_tlv16b());

        $wupBufferbytes = $loginBuffer->getBytes();
        if (!$this->isSecond) {
            $encrypt = Cryptor::encrypt($wupBufferbytes,
                                        0,
                                        strlen($wupBufferbytes),
                                        $this->qq->shareKey);
        } else {
            $encrypt = Cryptor::encrypt($wupBufferbytes,
                                        0,
                                        strlen($wupBufferbytes),
                                        $this->qq->randKey);
        }
        return $encrypt;
    }

    public function oicqRequestBuffer($cmd, $encrypt, $randKey, $pubKey)
    {
        static $subcmd = 0;
        $pack = new StreamOutputBuffer(new Buffer());
        //step03
        $pack->writeInt16BE($this->platformInfo->runtime->pcVer);
        //step04
        $pack->writeInt16BE($cmd);
        //step05
        $pack->writeInt16BE(++$subcmd);//sequence
        //step06
        $pack->writeInt32BE($this->qq->uin);
        /**
         * $pack->writeInt8("03");
         * $pack->writeInt8("00"); 87 //4.5=0x00; 4.7=0x07; 6.6.9=0x87或0x45
         * $pack->writeInt8($retry);
         * $pack->writeInt32BE($type);
         * $pack->writeInt32BE($no);
         * $pack->writeInt32BE($instance);
         */
        $pack->write(Hex::HexStringToBin("
        03 
        87 
        00 
        00 00 00 02 
        00 00 00 00 
        00 00 00 00"));
        //have 24 bytes used
        //end of head bytes writes
        //$pack->write(strlen($randKey), 0);
        //$pack->write($randKey, strlen($randKey))
        //$pack->write(strlen($encrypt), 0);
        //$pack->write($randKey, strlen($encrypt))

        if (!$this->isSecond) {
            $pack->writeHex("01 01");
            $pack->write($randKey);
            $pack->writeHex("01 02");
            $pack->writeInt16BE(strlen($pubKey));
            $pack->write($pubKey);
        } else {
            $pack->writeHex("01 02");
            $pack->write($randKey);
            $pack->writeHex("01 02");
            $pack->writeInt16BE(0);
        }

        $pack->write($encrypt);
        $pack->writeInt8(0x03);//end

        $finalBuffer_len = $pack->getLength() + 3;
        $finalBuffer     = (new Buffer($finalBuffer_len));
        //step01
        $finalBuffer->writeInt8(0x02, 0);
        //step02
        $finalBuffer->writeInt16BE($finalBuffer_len, 1); //27+2+body_len
        //step03
        $finalBuffer->write($pack->getBytes(), 3);
        return $finalBuffer->read(0, $finalBuffer_len);
    }

    //mark important
    public function get_tlv144()
    {
        $tlv109 = $this->get_tlv109();
        $tlv124 = $this->get_tlv124();
        $tlv128 = $this->get_tlv128();
        $tlv16e = $this->get_tlv16e();

        $tlv = $this->container->get('tlv.t144');
        return $tlv->get_tlv_144($tlv109, $tlv124, $tlv128, $tlv16e, $this->qq->TGTGT);
    }

    public function get_tlv18()
    {
        $tlv = $this->container->get('tlv.t18');
        return $tlv->get_tlv_18(
            $this->platformInfo->runtime->appId,
            $this->platformInfo->runtime->clientVersion,
            $this->qq->uin,
            0
        );
    }

    public function get_tlv1()
    {
        $tlv = $this->container->get('tlv.t1');
        return $tlv->get_tlv_1(
            $this->qq->uin,
            $this->platformInfo->network->clientIp
        );
    }

    public function get_tlv106()
    {
        $tlv = $this->container->get('tlv.t106');
        return $tlv->get_tlv_106(
            $this->platformInfo->runtime->appId,
            $this->platformInfo->runtime->subAppId,
            $this->platformInfo->runtime->clientVersion,
            $this->qq->uin,
            time(),
            $this->platformInfo->network->clientIp,
            $this->platformInfo->runtime->sevePwd,
            $this->qq->md5,
            //$uin,
            //$mUserAccount,
            $this->qq->TGTGT,
            $this->platformInfo->runtime->readflg,//readflg, imei readflag
            $this->platformInfo->android->android_device_mac_hash
        );
    }

    private function get_tlv116()
    {
        $tlv = $this->container->get('tlv.t116');
        return $tlv->get_tlv_116(
            $this->qq->bitmap,
            $this->qq->get_sig,
            []
        //[
        //    0x5f5e10e2
        //]
        );
    }

    private function get_tlv100()
    {
        $tlv = $this->container->get('tlv.t100');
        return $tlv->get_tlv_100(
            $this->platformInfo->runtime->appid,
            $this->platformInfo->runtime->wxAppId,
            $this->platformInfo->runtime->clientVersion,
            $this->qq->get_sig
        );
    }

    private function get_tlv107()
    {
        $tlv = $this->container->get('tlv.t107');
        return $tlv->get_tlv_107(
            $this->qq->picType, //00 00
            $this->qq->capType, //00
            $this->qq->picSize, //00 00
            $this->qq->retType //01
        );
    }

    private function get_tlv108()
    {
        $tlv = $this->container->get('tlv.t108');
        return $tlv->get_tlv_108(
            $this->qq->ksid //c5 91 b0 f2 d4 51 bb 9a 5a 70 49 bf 3d 50 6e 1f
        );
    }

    private function get_tlv109()
    {
        $tlv = $this->container->get('tlv.t109');
        return $tlv->get_tlv_109(
            $this->platformInfo->android->android_device_mac_hash
        );
    }

    private function get_tlv124()
    {
        $tlv = $this->container->get('tlv.t124');
        return $tlv->get_tlv_124(
            $this->platformInfo->android->osType,
            $this->platformInfo->android->osVersion,
            $this->platformInfo->network->networkType,
            $this->platformInfo->network->netDetail,
            $this->platformInfo->network->addr,
            $this->platformInfo->network->apn
        );
    }

    private function get_tlv128()
    {
        $tlv = $this->container->get('tlv.t128');
        return $tlv->get_tlv_128(
            $this->platformInfo->runtime->newinstall,//00
            $this->platformInfo->runtime->readguid,//01
            $this->platformInfo->runtime->guidchg,//00
            $this->platformInfo->runtime->dev_report,//10 00 00 00 _dev_report
            $this->platformInfo->android->deviceType, //MI 4LTE  _device
            $this->platformInfo->android->android_device_mac_hash, //d1 61 60 d5 b3 56 a0 a5 4f b9 93 24 a3 63 28 6b
            $this->platformInfo->android->deviceName//XiaoMi
        );
    }

    private function get_tlv16e()
    {
        $tlv = $this->container->get('tlv.t16e');
        return $tlv->get_tlv_16e(
            $this->platformInfo->android->deviceType
        );
    }

    private function get_tlv142()
    {
        $tlv = $this->container->get('tlv.t142');
        return $tlv->get_tlv_142(
        //com.tencent.mobileqq
        //63 6f 6d 2e 74 65 6e 63 65 6e 74 2e 6d 6f 62 69 6c 65 71 71
            $this->platformInfo->apk->apkId
        );
    }

    private function get_tlv145()
    {
        $tlv = $this->container->get('tlv.t145');
        return $tlv->get_tlv_145(
            $this->platformInfo->android->android_device_mac_hash
        );
    }

    private function get_tlv141()
    {
        $tlv = $this->container->get('tlv.t141');
        return $tlv->get_tlv_141(
            $this->platformInfo->network->operatorName,
            $this->platformInfo->network->networkType,
            $this->platformInfo->network->apn
        );
    }

    private function get_tlv8()
    {
        $tlv = $this->container->get('tlv.t8');
        return $tlv->get_tlv_8(
            0, $this->platformInfo->runtime->local_id, 0
        );
    }

    private function get_tlv16b()
    {
        $tlv = $this->container->get('tlv.t16b');
        return $tlv->get_tlv_16b(
            [
                "game.qq.com"
            ]);
    }

    private function get_tlv147()
    {
        $tlv = $this->container->get('tlv.t147');
        return $tlv->get_tlv_147(
            $this->platformInfo->runtime->appid,
            $this->platformInfo->apk->apk_version,
            $this->platformInfo->apk->sign
        );
    }

    private function get_tlv177()
    {
        $tlv = $this->container->get('tlv.t177');
        return $tlv->get_tlv_177(
            $this->platformInfo->runtime->time,
            $this->platformInfo->runtime->version //﻿5.2.3.0
        );
    }

    private function get_tlv187()
    {
        $tlv = $this->container->get('tlv.t187');
        return $tlv->get_tlv_187(
            $this->platformInfo->network->getHashMac()
        );
    }

    private function get_tlv188()
    {
        $tlv = $this->container->get('tlv.t188');
        return $tlv->get_tlv_188(
            $this->platformInfo->android->android_device_id
        );
    }

    private function get_tlv191()
    {
        $tlv = $this->container->get('tlv.t191');
        return $tlv->get_tlv_191();
    }

    private function get_tlv154()
    {
        $tlv = $this->container->get('tlv.t154');
        return $tlv->get_tlv_154(
            $this->ssoSeq
        );
    }

    private function get_tlv511()
    {
        $tlv = $this->container->get('tlv.t511');
        return $tlv->get_tlv_511(
            $this->platformInfo->runtime->userDomains
        );
    }

    private function get_tlv172()
    {
        $tlv = $this->container->get('tlv.t172');
        return $tlv->get_tlv_172(
            $this->qq->rollbackSig
        );
    }

    private function get_tlv194()
    {
        $tlv = $this->container->get('tlv.t194');
        return $tlv->get_tlv_194(
            $this->platformInfo->android->imsi
        );
    }

    private function get_tlv202()
    {
        $tlv = $this->container->get('tlv.t202');
        return $tlv->get_tlv_202(
            $this->platformInfo->network->bssid,
            $this->platformInfo->network->ssid
        );
    }

    private function get_tlv516()
    {
        $tlv = $this->container->get('tlv.t516');
        return $tlv->get_tlv_516(
            $this->platformInfo->runtime->source_type
        );
    }

    private function get_tlv521()
    {
        $tlv = $this->container->get('tlv.t521');
        return $tlv->get_tlv_521(
            $this->platformInfo->runtime->product_type
        );
    }

    private function get_tlv525()
    {
        $tlv  = $this->container->get('tlv.t525');
        $list = [];
        //$list[] = $this->get_tlv522();
        return $tlv->get_tlv_525(
            $list
        );
    }

    /**
     * 登录历史记录
     * [{
     * $loginExtraData['mUin']
     * $loginExtraData['mIp']
     * $loginExtraData['mTime']
     * $loginExtraData['mVersion']
     * }]
     *
     * @return mixed
     */
    private function get_tlv522()
    {
        $tlv = $this->container->get('tlv.t522');
        return $tlv->get_tlv_522([]);
    }


}