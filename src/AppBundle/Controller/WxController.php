<?php


namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WxController
{

    /**
     * @Route("/WXProxy/callback", name="wx")
     * @param Request $request
     * @return Response
     */
    public function wxAction(Request $request)
    {
        return new Response($_GET['echostr']);
    }

    /**
     * @Route("/wx/test001")
     * @param Request $request
     * @return Response
     */
    public function test001Action(Request $request)
    {
        //$app = $this->
        return new Response();
    }

}