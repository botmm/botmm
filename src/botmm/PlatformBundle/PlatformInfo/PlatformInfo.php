<?php


namespace botmm\PlatformBundle\PlatformInfo;


class PlatformInfo
{
    /**
     * @var Android
     */
    public $android;
    /**
     * @var Apk
     */
    public $apk;
    /**
     * @var Network
     */
    public $network;
    /**
     * @var Runtime
     */
    public $runtime;

    public function __construct($android, $apk, $network, $runtime)
    {
        $this->android = $android;
        $this->apk     = $apk;
        $this->network = $network;
        $this->runtime = $runtime;
    }
}