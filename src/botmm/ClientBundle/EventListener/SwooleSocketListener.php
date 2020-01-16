<?php


namespace botmm\ClientBundle\EventListener;


use botmm\ClientBundle\Event\SwooleSocketConnectEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SwooleSocketEventListener implements EventSubscriberInterface
{

    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
        ];
    }
}