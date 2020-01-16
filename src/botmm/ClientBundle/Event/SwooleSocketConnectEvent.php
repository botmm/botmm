<?php


namespace botmm\ClientBundle\Event;


use Symfony\Component\EventDispatcher\Event;

/**
 * {@inheritDoc}
 */
class SwooleSocketConnectEvent extends Event
{
    static $count = 0;

    public function __construct()
    {
        self::$count += 1;
    }
}