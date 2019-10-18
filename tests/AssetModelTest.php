<?php

namespace App\Tests\ModelTests;

use App\Model\Connection;
use App\Model\PDOAssetModel;
use App\Model\PDOAssetModelAssetModel;
use App\Model\ConnectionFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;

class AssetModelTest extends TestCase
{
    private $connection;

    public function setUp()
    {
        $connection = new Connection('mysql:host=127.0.0.1:3306;dbname=wamdb','root','');
    }

    public function testFindAssetByName()
    {

        $assetmodel = new PDOAssetModel($this->connection);
        $result = $assetmodel->findAssetByName('test');

        $this->assertNotEmpty($result);
    }
}