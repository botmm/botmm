<?php


namespace botmm\ClientBundle\Client;


use botmm\GradeeBundle\Oicq\Tlv\tlv_t1;
use botmm\GradeeBundle\Oicq\Tlv\tlv_t18;
use botmm\GradeeBundle\Oicq\Tools\Hex;

/**
 * Class Login
 *
 * _pub_key   020b03cf3d99541f29ffec281bebbd4ea211292ac1f53d7128
 * _share_key 4da0f614fc9f29c2054c77048a6566d7
 *
 * @package botmm\ClientBundle\Client
 */
class Login
{

    protected $uin;
    protected $appid;
    protected $client_version;
    protected $client_ip;

    public function __construct($uin)
    {
        $this->uin = $uin;
    }

    public function get_tlv18()
    {
        return (new tlv_t18())->get_tlv_18(
            Hex::HexStringToBin('00 00 00 10'),
            Hex::HexStringToBin('00 00 00 00'),
            $this->uin,
            0
        );
    }

    public function get_tlv1()
    {
        return (new tlv_t1())->get_tlv_1(
            $this->uin,
            $this->client_ip
        );
    }
}