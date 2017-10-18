<?php

namespace CitiesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AvisControllerTest extends WebTestCase
{
    public function testPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deposer-avis');
    }

    public function testListe()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/liste-avis/{regionSlug}/{departementSlug}/{villeSlug}');
    }

    public function testPostsave()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deposer-avis/gerer');
    }

}
