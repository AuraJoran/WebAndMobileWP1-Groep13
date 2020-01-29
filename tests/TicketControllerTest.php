<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TicketControllerTest extends WebTestCase
{
    private $client = null;
    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testTicketsGrouped()
    {

        $crawler = $this->client->request('GET', '/ticketsGrouped');
        $statuscode = $this->client->getResponse()->getStatusCode();
        $this->assertEquals(200, $statuscode);
        $this->assertSame('application/json', $this->client->getResponse()->headers->get('Content-Type'));
        $this->assertNotEmpty($this->client->getResponse()->getContent());
    }

    public function testResolveTicket()
    {

        $this->client->request('GET', '/tickets/resolve', ['id'=>'1']);
        $statuscode = $this->client->getResponse()->getStatusCode();
        $this->assertEquals(200, $statuscode);
    }

    public function testResolveTicket400()
    {
        $this->client->request('GET', '/tickets/resolve', ['id'=>'test']);
        $statuscode = $this->client->getResponse()->getStatusCode();
        $this->assertEquals(400, $statuscode);
    }

    public function test404()
    {
        $this->client->request('GET', '/tickets/resolverence', ['id'=>'test']);
        $statuscode = $this->client->getResponse()->getStatusCode();
        $this->assertEquals(404, $statuscode);
    }
}