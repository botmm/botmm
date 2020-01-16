<?php


namespace botmm\ClientBundle\Client;


use swoole_client;

class Client
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }



    public function run()
    {

    }

    protected function createClient()
    {
        swoole_async_dns_lookup('msfwifi.3g.qq.com', function ($host, $ip) {
            $client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

            //注册连接成功回调
            $client->on("connect", function ($cli) {
                $cli->send($this->packLogin());
            });

            //注册数据接收回调
            $client->on("receive", function ($cli, $data) {
                echo "Received: " . $data . "\n";
            });

            //注册连接失败回调
            $client->on("error", function ($cli) {
                echo "Connect failed\n";
            });

            //注册连接关闭回调
            $client->on("close", function ($cli) {
                echo "Connection close\n";
            });

            //发起连接
            $client->connect($ip, 8080, 0.5);
        });
    }

    private function packLogin()
    {
        $this->qq_info = $this->getContainer()->get('platform.qq_info');
        $this->global  = $this->getContainer()->get('platform.information');
        $buffer        = new Buffer();
        $loginBuffer   = new StreamOutputBuffer($buffer);
        $loginBuffer->writeHex("00 09");//sub_cmd
        $loginBuffer->writeInt16BE(0x18); //tlv 个数
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
        $encrypt        = Cryptor::encrypt($wupBufferbytes, 0, strlen($wupBufferbytes), $this->qq_info->shareKey);

        $packed = $this->fill_head(0x0810, $encrypt, $this->qq_info->randKey, $this->qq_info->pubKey);

        $this->Make_login_sendSsoMsg("wtlogin.login",
                                     $packed,
                                     "",
                                     $this->global->imei,
                                     $this->global->ksid,
                                     $this->global->ver,
                                     true);
    }

    private function Make_login_sendSsoMsg(
        $serviceCmd,
        $wupBuffer,
        $extBin,
        $imei,
        $ksid,
        $ver,
        $isLogin
    ) {
        $msgCookie = "﻿B6 CC 78 FC";

        $pack = new StreamOutputBuffer(new Buffer());
        $pack->writeInt32BE(
            4 + 4 + 4 + 4 + 12 +
            4 + strlen($extBin) +
            4 + strlen($serviceCmd) +
            4 + strlen($msgCookie) +
            4 + strlen($imei) +
            4 + strlen($ksid) +
            2 + strlen($ver)
        );
        $pack->writeInt32BE($this->global->requestId);
        $pack->writeInt32BE(0x20029f53);
        $pack->writeInt32BE(0x20029f53);
        //new 71 00 00 00 00 00 00 00 00 00 00 00
        $pack->writeHex("01 00 00 00 00 00 00 00 00 00 00 00");
        $pack->writeInt32BE(strlen($extBin));
        $pack->write($extBin, strlen($extBin));
        $pack->writeInt32BE(strlen($serviceCmd) + 4);
        $pack->write($serviceCmd);
        $pack->writeInt32BE(strlen($msgCookie) + 4);
        $pack->write($msgCookie);
        $pack->writeInt32BE(strlen($imei) + 4);
        $pack->write($imei);
        $pack->writeInt32BE(strlen($ksid) + 4);
        $pack->write($ksid);
        $pack->writeInt16BE(strlen($ver) + 2);
        $pack->write($ver);
        //new write something here

        $pack->writeInt32BE(strlen($wupBuffer) + 4);
        $pack->write($wupBuffer);
        $encrypt = Cryptor::encrypt($pack->getBytes(), 0, $pack->getLength(), $this->qq_info->key);
        return $isLogin ? $encrypt . hex2bin("00") : $encrypt . hex2bin("01");
    }

    public function fill_head($cmd, $encrypt, $randKey, $pubKey)
    {
        static $subcmd = 0;
        $pack = new StreamOutputBuffer(new Buffer());
        //step03
        $pack->writeInt8($this->global->pcVer);
        //step04
        $pack->writeInt16BE($cmd);
        //step05
        $pack->writeInt16BE($subcmd++);//sequence
        //step06
        $pack->writeInt32BE($this->qq_info->uin);
        /**
         * $pack->writeInt8("03");
         * $pack->writeInt8("00");
         * $pack->writeInt8($retry);
         * $pack->writeInt32BE($type);
         * $pack->writeInt32BE($no);
         * $pack->writeInt32BE($instance);
         */
        $pack->write(Hex::HexStringToBin("
        ﻿03 
        07 
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

        $pack->writeHex("01 01");
        $pack->write($randKey);
        $pack->writeHex("01 02");
        $pack->writeInt16BE(strlen($pubKey));
        if ($pubKey) {
            $pack->write($pubKey);
        } else {
            $pack->writeHex("00 00");
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

    public function get_tlv144()
    {
        $tlv109 = $this->get_tlv109();
        $tlv124 = $this->get_tlv124();
        $tlv128 = $this->get_tlv128();
        $tlv16e = $this->get_tlv16e();

        $tlv = $this->getContainer()->get('tlv.t144');
        return $tlv->get_tlv_144($tlv109, $tlv124, $tlv128, $tlv16e, $this->qq_info->TGTKey);
    }

    public function get_tlv18()
    {
        $tlv = $this->getContainer()->get('tlv.t18');
        return $tlv->get_tlv_18(
            $this->global->appId,
            $this->global->clientVersion,
            $this->qq_info->uin,
            0
        );
    }

    public function get_tlv1()
    {
        $tlv = $this->getContainer()->get('tlv.t1');
        return $tlv->get_tlv_1(
            $this->qq_info->uin,
            $this->global->clientIp
        );
    }

    public function get_tlv106()
    {
        $tlv = $this->getContainer()->get('tlv.t106');
        return $tlv->get_tlv_106(
            $this->global->appId,
            $this->global->subAppId,
            $this->global->clientVersion,
            $this->qq_info->uin,
            $this->global->initTime,
            $this->global->clientIp,
            $this->global->sevePwd,
            $this->qq_info->md5,
            //$uin,
            //$mUserAccount,
            $this->qq_info->TGTGT,
            $this->global->readflg,//readflg, imei readflag
            $this->global->imei
        );
    }

    private function get_tlv116()
    {
        $tlv = $this->getContainer()->get('tlv.t116');
        return $tlv->get_tlv_116(
            $this->qq_info->bitmap,
            $this->qq_info->get_sig,
            [
                $this->global->appid
            ]
        );
    }

    private function get_tlv100()
    {
        $tlv = $this->getContainer()->get('tlv.t100');
        return $tlv->get_tlv_100(
            $this->global->appid,
            $this->global->wxAppId,
            $this->global->clientVersion,
            $this->qq_info->get_sig
        );
    }

    private function get_tlv107()
    {
        $tlv = $this->getContainer()->get('tlv.t107');
        return $tlv->get_tlv_107(
            $this->qq_info->picType, //00 00
            $this->qq_info->capType, //00
            $this->qq_info->picSize, //00 00
            $this->qq_info->retType //01
        );
    }

    private function get_tlv108()
    {
        $tlv = $this->getContainer()->get('tlv.t108');
        return $tlv->get_tlv_108(
            $this->global->ksid //c5 91 b0 f2 d4 51 bb 9a 5a 70 49 bf 3d 50 6e 1f
        );
    }

    private function get_tlv109()
    {
        $tlv = $this->getContainer()->get('tlv.t109');
        return $tlv->get_tlv_109(
            $this->global->imei
        );
    }

    private function get_tlv124()
    {
        $tlv = $this->getContainer()->get('tlv.t124');
        return $tlv->get_tlv_124(
            $this->global->osType,
            $this->global->osVersion,
            $this->global->network_type,
            $this->global->netdetail,
            $this->global->addr,
            $this->global->apn
        );
    }

    private function get_tlv128()
    {
        $tlv = $this->getContainer()->get('tlv.t128');
        return $tlv->get_tlv_128(
            $this->global->newinstall,//00
            $this->global->readguid,//01
            $this->global->guidchg,//00
            $this->global->dev_report,//10 00 00 00 _dev_report
            $this->global->devicetype, //MI 4LTE  _device
            $this->global->imei, //d1 61 60 d5 b3 56 a0 a5 4f b9 93 24 a3 63 28 6b
            $this->global->deviceName//XiaoMi
        );
    }

    private function get_tlv16e()
    {
        $tlv = $this->getContainer()->get('tlv.t16e');
        return $tlv->get_tlv_16e(
            $this->global->devicetype
        );
    }

    private function get_tlv142()
    {
        $tlv = $this->getContainer()->get('tlv.t142');
        return $tlv->get_tlv_142(
        //com.tencent.mobileqq
        //63 6f 6d 2e 74 65 6e 63 65 6e 74 2e 6d 6f 62 69 6c 65 71 71
            $this->global->_apkId
        );
    }

    private function get_tlv145()
    {
        $tlv = $this->getContainer()->get('tlv.t145');
        return $tlv->get_tlv_145(
            $this->global->imei
        );
    }

    private function get_tlv141()
    {
        $tlv = $this->getContainer()->get('tlv.t141');
        return $tlv->get_tlv_141(
            $this->global->operator_name,
            $this->global->network_type,
            $this->global->apn
        );
    }

    private function get_tlv8()
    {
        $tlv = $this->getContainer()->get('tlv.t8');
        return $tlv->get_tlv_8(
            0, $this->global->local_id, 0
        );
    }

    private function get_tlv16b()
    {
        $tlv = $this->getContainer()->get('tlv.t16b');
        return $tlv->get_tlv_16b(
            [
                "game.qq.com"
            ]);
    }

    private function get_tlv147()
    {
        $tlv = $this->getContainer()->get('tlv.t147');
        return $tlv->get_tlv_147(
            $this->global->appid,
            $this->global->appVer,
            $this->global->appSign
        );
    }

    private function get_tlv177()
    {
        $tlv = $this->getContainer()->get('tlv.t177');
        return $tlv->get_tlv_177(
            $this->global->time,
            $this->global->version //﻿5.2.3.0
        );
    }

    private function get_tlv187()
    {
        $tlv = $this->getContainer()->get('tlv.t187');
        return $tlv->get_tlv_187(
            $this->global->macHash
        );
    }

    private function get_tlv188()
    {
        $tlv = $this->getContainer()->get('tlv.t188');
        return $tlv->get_tlv_188(
            $this->global->android_id
        );
    }

    private function get_tlv191()
    {
        $tlv = $this->getContainer()->get('tlv.t191');
        return $tlv->get_tlv_191();
    }

    private function get_tlv154()
    {
        $tlv = $this->getContainer()->get('tlv.t154');
        return $tlv->get_tlv_154(
            $this->global->ssoSeq
        );
    }

    private function get_tlv511()
    {
        $tlv = $this->getContainer()->get('tlv.t511');
        return $tlv->get_tlv_511(
            $this->global->userDomains
        );
    }

    private function get_tlv194()
    {
        $tlv = $this->getContainer()->get('tlv.t194');
        return $tlv->get_tlv_194(
            $this->global->imsi
        );
    }

    private function get_tlv202()
    {
        $tlv = $this->getContainer()->get('tlv.t202');
        return $tlv->get_tlv_202(
            $this->global->bssidaddr,
            $this->global->ssid
        );
    }

    private function get_tlv516()
    {
        $tlv = $this->getContainer()->get('tlv.t516');
        return $tlv->get_tlv_516(
            $this->global->source_type
        );
    }

    private function get_tlv521()
    {
        $tlv = $this->getContainer()->get('tlv.t521');
        return $tlv->get_tlv_521(
            $this->global->product_type
        );
    }

    private function get_tlv525()
    {
        $tlv = $this->getContainer()->get('tlv.t525');
        return $tlv->get_tlv_525(
            $this->get_tlv522()
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
        $tlv = $this->getContainer()->get('tlv.t522');
        return $tlv->get_tlv_522([]);
    }
}