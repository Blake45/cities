<?php

namespace CitiesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DebugControllerTest extends WebTestCase
{
    public function testPhpinfo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/phpinfo');
    }

}
