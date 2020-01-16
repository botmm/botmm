<?php


namespace botmm\ClientBundle\Controller;


use Exception;
use Icicle\Coroutine\Coroutine;
use Icicle\Socket\Socket;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Icicle\Dns;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class ClientController extends Controller
{
    /**
     * @var Socket
     */
    public $socket;

    /**
     * @Route("/login")
     */
    public function loginAction() {
        $this->createTcpClient();

        $generator = function (Socket $socket) {

            $message = sprintf("Received the following request:\r\n\r\n%s", "sdf");

            $data  = "HTTP/1.1 200 OK\r\n";
            $data .= "Content-Type: text/plain\r\n";
            $data .= sprintf("Content-Length: %d\r\n", strlen($message));
            $data .= "Connection: close\r\n";
            $data .= "\r\n";
            $data .= $message;

            yield $socket->write($data);


            $response = '';
            $response .= (yield $socket->read(0, "\n"));

            echo $response;
        };

        $co = new Coroutine($generator($this->socket));
        $co->done();

        return new Response("hello");

    }


    public function createTcpClient() {
        $coroutine = new Coroutine(Dns\connect('msfwifi.3g.qq.com', 8080));

        $coroutine->done(
            function (Socket $client) {
                $this->socket = $client;
                echo "IP: {$client->getRemoteAddress()}\n";
                echo "Port: {$client->getRemotePort()}\n";
            },
            function (Exception $exception) {
                echo "Connecting failed: {$exception->getMessage()}\n";
            }
        );

        $coroutine->wait();

    }

}