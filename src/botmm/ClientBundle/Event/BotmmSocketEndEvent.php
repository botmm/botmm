<?php


namespace botmm\ClientBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class BotmmSocketEndEvent extends Event
{
    const NAME = 'botmm.socket.end';

    protected $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }

}