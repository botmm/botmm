<?php


namespace botmm\Tars\Protocol\Tars\Tests\TarsStreamEx;


/**
 * Class JceSample001
 * @JceStruct()
 *
 * @package botmm\Tars\Protocol\Tars\Tests\TarsStreamEx
 */
class JceSample001
{

    /**
     * @JceProperty(order=1, isRequire=true, comment="foo property")
     * @JceProperty(order=1, name="foo", stamp="int" comment="foo property", isRequire=true, default="")
     */
    public $foo;

    /**
     * @JceProperty()
     */
    public $bar;

    /**
     * @JceProperty()
     */
    public $baz;

    /**
     * @JceProperty()
     */
    public $quz;

}