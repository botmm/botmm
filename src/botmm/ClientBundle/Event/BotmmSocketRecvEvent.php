<?php


namespace botmm\ClientBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class BotmmSocketRecvEvent extends Event
{
    const NAME = 'botmm.socket.recv';

    protected $chunk;

    public function __construct($chunk)
    {
        $this->chunk = $chunk;
    }

    public function getChunk()
    {
        return $this->chunk;
    }

}