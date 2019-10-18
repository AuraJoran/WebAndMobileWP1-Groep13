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

    public function testFindAssetByName()
    {
        $connection = new Connection('mysql:host=192.168.33.22:3306;dbname=wamdb','root','root');

        $assetmodel = new PDOAssetModel($connection);
        $result = $assetmodel->findAssetByName('test');

        $this->assertNotEmpty($result);
    }
}