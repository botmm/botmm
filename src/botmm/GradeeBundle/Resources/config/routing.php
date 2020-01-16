<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('botmm_gradee_homepage', new Route('/', array(
    '_controller' => 'botmmGradeeBundle:Default:index',
)));

return $collection;
