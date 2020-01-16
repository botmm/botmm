<?php

namespace test\Test001Bundle\Controller;

use Exception;
use Icicle\Coroutine\Coroutine;
use Icicle\Socket\Socket;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Icicle\Loop;
use Icicle\Dns;
use Icicle\Awaitable;

class DefaultController extends Controller
{

    public function __construct()
    {
    }

    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('testTest001Bundle:Default:index.html.twig');
    }

    /**
     * @Route("/test001")
     * @return Response
     */
    public function test001Action()
    {
        $coroutine = new Coroutine(Dns\connect('baidu.com', 80));

        $ip = null;
        $port = null;
        $coroutine->done(
            function (Socket $client) use(&$ip, &$port) {
                echo "IP: {$client->getRemoteAddress()}\n";
                echo "Port: {$client->getRemotePort()}\n";
                $ip = $client->getRemoteAddress();
                $port = $client->getRemotePort();
            },
            function (Exception $exception) {
                echo "Connecting failed: {$exception->getMessage()}\n";
            }
        );

        return new Response("ip: $ip, port: $port");
    }

    /**
     * @Route("/test002")
     */
    public function test002Action()
    {
        $callback = function ($value) {
            $awaitable = Awaitable\resolve($value);

            // Delays coroutine execution for 1 second.
            yield $awaitable->delay(10);
        };


        // $coroutine will be rejected with thrown exception.
        $coroutine = new Coroutine($callback(3.14159));

        $coroutine->wait();

        $coroutine->then(
            function ($result) {
                echo "Result: {$result}\n";
            },
            function (Exception $e) {
                echo "Error: {$e->getMessage()}\n";
            }
        );

        return new Response("");
    }

    /**
     * @Route("/test003", name="test003")
     * @return Response
     */
    public function test003Action()
    {
        $messages   = [];
        $routine1   = new Coroutine($this->sayHello('Baby'));
        $routine2   = new Coroutine($this->sayHello('Ginger'));
        $routine3   = new Coroutine($this->sayHello('Posh'));
        $routine4   = new Coroutine($this->sayHello('Scary'));
        $routine5   = new Coroutine($this->sayHello('Sporty'));
        $messages[] = $routine1->wait();
        $messages[] = $routine2->wait();
        $messages[] = $routine3->wait();
        $messages[] = $routine4->wait();
        $messages[] = $routine5->wait();
        // replace this example code with whatever you need
        //return $this->render('default/index.html.twig', [
        //    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        //    'messages' => $messages
        //]);

        return new Response(print_r($messages, true));
    }

    public function sayHello($name)
    {
        $delay   = rand(1, 5);
        $message = ["Hello! My name is " . $name, $delay];
        $promise = Awaitable\resolve($message);
        yield $promise->delay($delay);
    }


}
