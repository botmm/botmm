<?php


namespace botmm\GradeeBundle\Oicq\Pack;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamOutputBuffer;
use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Tools\Hex;
use botmm\PlatformBundle\PlatformInfo\PlatformInfo;
use botmm\PlatformBundle\PlatformInfo\QqInfo;

class MakeLoginSendSsoMsg
{

    public $serviceCmd = "wtlogin.login";


    /**
     * @var PlatformInfo
     */
    protected $platformInfo;
    /**
     * @var QqInfo
     */
    protected $qq;

    public function __construct($platformInfo, $qq_info)
    {
        $this->platformInfo = $platformInfo;
        $this->qq           = $qq_info;
    }

    public function pack($wupBuffer, $extBin)
    {
        $encrypt = $this->sendSsoMsg(
            $this->serviceCmd,
            $wupBuffer,
            $extBin,
            $this->platformInfo->android->imei,
            $this->qq->ksid,
            $this->platformInfo->apk->version,
            true);

        $stream = new StreamOutputBuffer(new Buffer());
        $qq     = $this->qq->QQ;
        $stream->writeInt32BE(4 + 10 + 4 + strlen($qq) + strlen($encrypt));
        $stream->writeHex("00 00 00 0A 02 00 00 00 04 00");
        //$stream->writeHex("00 00 00 0B 02 00 00 82 97 00"); //sendSsoMsgSimple
        $stream->writeInt32BE(strlen($qq) + 4);
        $stream->write($qq, strlen($qq));
        $stream->write($encrypt);
        return $stream->getBytes();
    }


    public function sendSsoMsg(
        $serviceCmd,
        $wupBuffer,
        $extBin,
        $imei,
        $ksid,
        $ver,
        $isLogin
    ) {
        $msgCookie = Hex::HexStringToBin("B6 CC 78 FC");

        $pack = new StreamOutputBuffer(new Buffer());
        $pack->writeInt32BE(
            4 + //self
            4 + 4 + 4 + 12 +
            4 + strlen($extBin) +
            4 + strlen($serviceCmd) +
            4 + strlen($msgCookie) +
            4 + strlen($imei) +
            4 + strlen($ksid) +
            2 + strlen($ver) +
            4
        );
        $pack->writeInt32BE($this->platformInfo->runtime->requestId);
        $pack->writeInt32BE(0x20029f53);
        $pack->writeInt32BE(0x20029f53);
        //new 71 00 00 00 00 00 00 00 00 00 00 00
        $pack->writeHex("01 00 00 00 00 00 00 00 00 00 00 00");
        $pack->writeInt32BE(strlen($extBin) + 4);
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
        $pack->writeInt32BE(0 + 4);
        //$pack->write();

        $pack->writeInt32BE(strlen($wupBuffer) + 4);
        $pack->write($wupBuffer);
        $encrypt = Cryptor::encrypt($pack->getBytes(), 0, $pack->getLength(), $this->qq->key);
        return $encrypt;
        //return $isLogin ? $encrypt . hex2bin("00") : $encrypt . hex2bin("01");
    }

    public function packSimple($wupBuffer, $extBin)
    {
        $encrypt = $this->sendSsoMsgSimple(
            $this->serviceCmd,
            $wupBuffer,
            $extBin
        );

        $stream = new StreamOutputBuffer(new Buffer());
        $qq     = $this->qq->QQ;
        $stream->writeInt32BE(4 + 10 + 4 + strlen($qq) + strlen($encrypt));
        //$stream->writeHex("00 00 00 0A 02 00 00 00 04 00");
        $stream->writeHex("00 00 00 0B 02 00 00 82 97 00"); //sendSsoMsgSimple
        $stream->writeInt32BE(strlen($qq) + 4);
        $stream->write($qq, strlen($qq));
        $stream->write($encrypt);
        return $stream->getBytes();
    }


    public function sendSsoMsgSimple(
        $serviceCmd,
        $wupBuffer,
        $extBin
    ) {
        $msgCookie = Hex::HexStringToBin("B6 CC 78 FC");

        $pack = new StreamOutputBuffer(new Buffer());
        $pack->writeInt32BE(
            4 + 4 + 4 + 4 + 12 +
            4 + strlen($extBin) +
            4 + strlen($serviceCmd) +
            4 + strlen($msgCookie)
        );
        $pack->writeInt32BE(strlen($serviceCmd) + 4);
        $pack->write($serviceCmd);
        $pack->writeInt32BE(strlen($msgCookie) + 4);
        $pack->write($msgCookie);
        $pack->writeInt32BE(strlen($extBin) + 4);
        $pack->write($extBin, strlen($extBin));

        $pack->writeInt32BE(strlen($wupBuffer) + 4);
        $pack->write($wupBuffer);
        $encrypt = Cryptor::encrypt($pack->getBytes(), 0, $pack->getLength(), $this->qq->key);
        return $encrypt;
    }

}