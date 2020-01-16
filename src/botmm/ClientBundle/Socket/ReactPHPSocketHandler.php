<?php


namespace botmm\ClientBundle\Socket;


use botmm\ClientBundle\Event\BotmmSocketCloseEvent;
use botmm\ClientBundle\Event\BotmmSocketEndEvent;
use botmm\ClientBundle\Event\BotmmSocketRecvEvent;
use botmm\ClientBundle\Event\BotmmSocketSendEvent;
use React\SocketClient\ConnectionInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ReactPHPSocketHandler
{
    private $eventDispatcher;

    /**
     * ReactPHPSocketHandler constructor.
     *
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(ConnectionInterface $connection)
    {
        // connection successfully established
        $connection->on('data', function ($chunk) use ($connection) {
            $this->eventDispatcher->dispatch(
                BotmmSocketRecvEvent::NAME,
                new BotmmSocketRecvEvent($connection, $chunk));
        });

        $connection->on('end', function () use ($connection) {
            $this->eventDispatcher->dispatch(
                BotmmSocketEndEvent::NAME,
                new BotmmSocketEndEvent($connection)
            );
        });

        $connection->on('error', function (Exception $e) use($connection){
            $this->eventDispatcher->dispatch(
                BotmmSocketErrorEvent::NAME,
                new BotmmSocketEndEvent($connection)
            );
        });

        $connection->on('close', function () use ($connection) {
            $this->eventDispatcher->dispatch(
                BotmmSocketCloseEvent::NAME,
                new BotmmSocketCloseEvent($connection)
            );
        });

        //dispatch Socket Connect
        //listen Framework dispatch Request Event
        $connection->write($this->data);
    }

}