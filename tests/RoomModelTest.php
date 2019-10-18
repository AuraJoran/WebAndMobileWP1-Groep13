<?php

namespace App\Tests\ModelTests;

use App\Model\Connection;
use App\Model\PDOAssetModelAssetModel;
use App\Model\ConnectionFactory;
use App\Model\PDORoomModel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;

class RoomModelTest extends TestCase
{
    private $connection;

    public function setUp()
    {
        $this->connection = new Connection('mysql:host=127.0.0.1:3306;dbname=wamdb','root','');
    }

    public function testFindRoomByName()
    {

        $roommodel = new PDORoomModel($this->connection);
        $result = $roommodel->findRoomByName('test');

        $this->assertNotEmpty($result);
    }
    public function testFindRoomsWithLesserHappinessScore()
    {

        $roommodel = new PDORoomModel($this->connection);
        $result = $roommodel->findRoomsWithLesserHappinessScore("5");

        $this->assertNotEmpty($result);
    }

    public function testInvalidName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $assetmodel = new PDORoomModel($this->connection);
        $result = $assetmodel->findRoomByName(9);
    }
    public function testInvalidHappinessScore()
    {
        $this->expectException(\InvalidArgumentException::class);

        $assetmodel = new PDORoomModel($this->connection);
        $value = "test";
        $result = $assetmodel->findRoomsWithLesserHappinessScore($value);
    }
}