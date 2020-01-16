<?php

namespace botmm\connection;

use swoole_client;

class BotmmTcpConnector
{

    /**
     * @var swoole_client;
     */
    private $client;


    public function __constructor()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP);
    }

    public function connect($address)
    {
        if (is_array($address)) {
            [$host, $port] = $address;
            $this->client->connect($host, $port);
        } elseif ($address instanceof ConnectorAddress) {
            if ($address->protocol == 'socket') {
                $this->client->connect($address->host, $address->port);
            } else {
                throw new \Exception('must socket protocol');
            }
        }
    }

    public function send($data)
    {
        $this->client->send($data);
    }

    public function close()
    {
        $this->client->close();
    }
}