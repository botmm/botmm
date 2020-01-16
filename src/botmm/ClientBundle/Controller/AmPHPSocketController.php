<?php


namespace botmm\ClientBundle\Controller;


use Amp\Socket\Client;
use Amp\Socket;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AmPHPSocketController extends Controller
{

    /**
     * @Route("am_socket")
     */
    public function amSocketAction()
    {
        $promise = Socket\connect("tcp://220.181.57.217:8080");

        $promise->when(function ($e, $socket) {
            $client = new Client($socket);

            while ($client->alive()) {
                yield $client->write('abc');

            }
        });

        return new Response("sss");

    }

}