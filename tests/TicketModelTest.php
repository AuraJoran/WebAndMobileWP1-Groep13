<?php

namespace App\Tests\ModelTests;

use App\Model\Connection;
use App\Model\PDOAssetModelAssetModel;
use App\Model\ConnectionFactory;
use App\Model\PDORoomModel;
use App\Model\PDOTicketModel;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Json;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;
use function MongoDB\BSON\fromJSON;

class TicketModelTest extends TestCase
{
    private $connection;

    public function setUp()
    {
        $this->connection = new Connection('mysql:host=127.0.0.1:3306;dbname=wamdb','root','');
    }

    public function testFindTicketsByAssetName()
    {

        $ticketmodel = new PDOTicketModel($this->connection);
        $result = $ticketmodel->findTicketsByAssetName('test');

        $this->assertNotEmpty($result);
    }


    public function testAddNumberOfVotesByOne()
    {

        $ticketmodel = new PDOTicketModel($this->connection);
        $result = $ticketmodel->findTicketsByAssetName("test");
        $before = json_decode(reset($result)['numberOfVotes'], true);
        $ticketmodel->addNumberOfVotesByOne("1");
        $result = $ticketmodel->findTicketsByAssetName("test");
        $after = json_decode(reset($result)['numberOfVotes'], true);

        $this->assertEquals($before +1, $after);
    }

    public function testValidateAssetName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $ticketmodel = new PDOTicketModel($this->connection);
        $result = $ticketmodel->findTicketsByAssetName(9);
    }
    public function testValidateId()
    {
        $this->expectException(\InvalidArgumentException::class);

        $ticketmodel = new PDOTicketModel($this->connection);
        $result = $ticketmodel->addNumberOfVotesByOne("test");
    }

    public function testFindTicketsGrouped()
    {

        $ticketmodel = new PDOTicketModel($this->connection);
        $result = $ticketmodel->findAllTicketsGrouped();

        $this->assertNotEmpty($result);
    }

    public function testIsResolved()
    {

        $ticketmodel = new PDOTicketModel($this->connection);
        $result = $ticketmodel->findTicketsByAssetName("test");
        $before = json_decode(reset($result)['resolved'], true);
        $ticketmodel->isResolved("1");
        $result = $ticketmodel->findTicketsByAssetName("test");
        $after = json_decode(reset($result)['resolved'], true);

        $this->assertNotEquals($before, $after);
    }
}