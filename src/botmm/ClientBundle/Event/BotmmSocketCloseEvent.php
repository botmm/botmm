<?php


namespace botmm\ClientBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class BotmmSocketCloseEvent extends Event
{
    const NAME = 'botmm.socket.close';

    public $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

}