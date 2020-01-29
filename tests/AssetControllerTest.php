<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AssetControllerTest extends WebTestCase
{
    public function testAssetsWithTickets()
    {
        $client = static::createClient();

        $client->request('GET', '/assetsWithTickets');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertNotEmpty($client->getResponse()->getContent());

    }
}