<?php

namespace AppBundle\Cypher\Tests;

use AppBundle\Cypher\QQTEA;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QqTeaTest extends WebTestCase
{
    public function testIndex()
    {

    }

    public function testCypher()
    {
        $data = 'abcdef';
        $key = '00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00';
        $result = QQTEA::encrypt($key, $data);

        print_r($result);

    }
}
