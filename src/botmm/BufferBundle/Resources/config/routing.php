<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('botmm_buffer_homepage', new Route('/', array(
    '_controller' => 'botmmBufferBundle:Default:index',
)));

return $collection;
