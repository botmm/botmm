<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;


//$container->addDefinitions(
//    [
//        'platform.device'      => new Definition('botmm\GradeeBundle\Oicq\Platform\AndroidDevice'),
//        'platform.apk'         => new Definition('botmm\GradeeBundle\Oicq\Platform\ApkInfo'),
//        'platform.information' => new Definition('botmm\GradeeBundle\Oicq\Platform\PlatformInformation',
//                                                 [
//                                                     new Reference('platform.device'),
//                                                     new Reference('platform.apk')
//                                                 ]),
//        'platform.qq_info'     => new Definition('botmm\GradeeBundle\Oicq\Platform\QqInfo'),
//    ]
//);


$container->addDefinitions(
    [
        'botmm_gradee.pack.login' =>
            (new Definition('botmm\GradeeBundle\Oicq\Pack\LoginPack'))
                ->addArgument(new Reference('botmm_platform.platform_info'))
                ->addArgument(new Reference('botmm_platform.qq_info'))
                ->addMethodCall('setContainer', [new Reference('service_container')]),
        'botmm_gradee.pack.make_login_send_sso_msg' =>
            (new Definition('botmm\GradeeBundle\Oicq\Pack\MakeLoginSendSsoMsg'))
                ->addArgument(new Reference('botmm_platform.platform_info'))
                ->addArgument(new Reference('botmm_platform.qq_info'))

    ]
);


$container->addDefinitions(
    [
        'tlv.t1'   => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t1'))->setShared(false),
        'tlv.t2'   => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t2'))->setShared(false),
        'tlv.t8'   => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t8'))->setShared(false),
        'tlv.t10a' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10a'))->setShared(false),
        'tlv.t10b' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10b'))->setShared(false),
        'tlv.t10c' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10c'))->setShared(false),
        'tlv.t10d' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10d'))->setShared(false),
        'tlv.t10e' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t10e'))->setShared(false),
        'tlv.t11a' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t11a'))->setShared(false),
        'tlv.t11c' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t11c'))->setShared(false),
        'tlv.t11d' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t11d'))->setShared(false),
        'tlv.t11f' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t11f'))->setShared(false),
        'tlv.t16a' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t16a'))->setShared(false),
        'tlv.t16b' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t16b'))->setShared(false),
        'tlv.t16e' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t16e'))->setShared(false),
        'tlv.t18'  => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t18'))->setShared(false),
        'tlv.t100' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t100'))->setShared(false),
        'tlv.t102' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t102'))->setShared(false),
        'tlv.t103' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t103'))->setShared(false),
        'tlv.t104' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t104'))->setShared(false),
        'tlv.t105' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t105'))->setShared(false),
        'tlv.t106' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t106'))->setShared(false),
        'tlv.t107' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t107'))->setShared(false),
        'tlv.t108' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t108'))->setShared(false),
        'tlv.t109' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t109'))->setShared(false),
        'tlv.t113' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t113'))->setShared(false),
        'tlv.t114' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t114'))->setShared(false),
        'tlv.t116' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t116'))->setShared(false),
        'tlv.t119' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t119'))->setShared(false),
        'tlv.t120' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t120'))->setShared(false),
        'tlv.t121' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t121'))->setShared(false),
        'tlv.t122' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t122'))->setShared(false),
        'tlv.t124' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t124'))->setShared(false),
        'tlv.t125' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t125'))->setShared(false),
        'tlv.t126' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t126'))->setShared(false),
        'tlv.t128' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t128'))->setShared(false),
        'tlv.t129' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t129'))->setShared(false),
        'tlv.t130' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t130'))->setShared(false),
        'tlv.t132' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t132'))->setShared(false),
        'tlv.t133' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t133'))->setShared(false),
        'tlv.t134' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t134'))->setShared(false),
        'tlv.t135' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t135'))->setShared(false),
        'tlv.t136' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t136'))->setShared(false),
        'tlv.t138' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t138'))->setShared(false),
        'tlv.t140' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t140'))->setShared(false),
        'tlv.t141' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t141'))->setShared(false),
        'tlv.t142' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t142'))->setShared(false),
        'tlv.t143' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t143'))->setShared(false),
        'tlv.t144' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t144'))->setShared(false),
        'tlv.t145' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t145'))->setShared(false),
        'tlv.t146' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t146'))->setShared(false),
        'tlv.t147' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t147'))->setShared(false),
        'tlv.t148' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t148'))->setShared(false),
        'tlv.t149' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t149'))->setShared(false),
        'tlv.t150' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t150'))->setShared(false),
        'tlv.t151' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t151'))->setShared(false),
        'tlv.t152' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t152'))->setShared(false),
        'tlv.t153' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t153'))->setShared(false),
        'tlv.t154' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t154'))->setShared(false),
        'tlv.t164' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t164'))->setShared(false),
        'tlv.t165' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t165'))->setShared(false),
        'tlv.t166' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t166'))->setShared(false),
        'tlv.t167' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t167'))->setShared(false),
        'tlv.t169' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t169'))->setShared(false),
        'tlv.t171' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t171'))->setShared(false),
        'tlv.t172' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t172'))->setShared(false),
        'tlv.t177' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t177'))->setShared(false),
        'tlv.t187' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t187'))->setShared(false),
        'tlv.t188' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t188'))->setShared(false),
        'tlv.t191' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t191'))->setShared(false),
        'tlv.t194' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t194'))->setShared(false),
        'tlv.t202' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t202'))->setShared(false),
        'tlv.t305' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t305'))->setShared(false),
        'tlv.t511' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t511'))->setShared(false),
        'tlv.t516' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t516'))->setShared(false),
        'tlv.t521' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t521'))->setShared(false),
        'tlv.t522' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t522'))->setShared(false),
        'tlv.t525' => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_t525'))->setShared(false),
        'tlv.ta'   => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_ta'))->setShared(false),
        'tlv.tc'   => (new Definition('botmm\GradeeBundle\Oicq\Tlv\Tlv_tc'))->setShared(false),
    ]
);
