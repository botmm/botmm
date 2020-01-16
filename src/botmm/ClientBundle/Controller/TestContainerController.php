<?php


namespace botmm\ClientBundle\Controller;


use botmm\ClientBundle\Event\SwooleSocketConnectEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestContainerController extends Controller
{

    /**
     * @Route("test_client")
     */
    public function clientAction()
    {
        $clas = $this->get('botmm.client.swoole_socket_connect_event');

        return new Response(SwooleSocketConnectEvent::$count);


    }

}