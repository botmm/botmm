<?php


namespace botmm\ClientBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class BotmmSocketSendEvent extends Event
{
    const NAME = 'botmm.socket.send';

    protected $chunk;

    public function __construct($socket, $chunk)
    {
        $this->chunk = $chunk;
    }

    public function getChunk()
    {
        return $this->chunk;
    }

}