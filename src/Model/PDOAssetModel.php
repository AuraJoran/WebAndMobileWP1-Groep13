<?php

namespace App\Model;

class PDOAssetModel implements AssetModel {
    
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function findAssetByName($name)
    {
        $this->validateName($name);
        $pdo = $this->connection->getPDO();
        $statement = $pdo->prepare('SELECT * FROM assets WHERE name=:name');
        $statement->bindParam(':name', $name, \PDO::PARAM_STR);
        $statement->execute();
        $statement->bindColumn(1, $id, \PDO::PARAM_INT);
        $statement->bindColumn(2, $roomdId, \PDO::PARAM_INT);
        $statement->bindColumn(3, $name, \PDO::PARAM_STR);
        $asset = null;
        if ($statement->fetch(\PDO::FETCH_BOUND)) {
            $asset = ['id' => $id, 'roomId' => $roomdId, 'name' => $name];
        }
        return $asset;
    }

    public function findAssetsByRoom($roomId)
    {
        $this->validateName($roomId);
        $pdo = $this->connection->getPDO();
        $statement = $pdo->prepare('SELECT * FROM assets WHERE roomId=:roomId');
        $statement->bindParam(':roomId', $roomId, \PDO::PARAM_STR);
        $statement->execute();
        $statement->bindColumn(1, $id, \PDO::PARAM_INT);
        $statement->bindColumn(2, $roomdId, \PDO::PARAM_INT);
        $statement->bindColumn(3, $name, \PDO::PARAM_STR);
        $assets = [];
        $counter = 0;
        while ($statement->fetch(\PDO::FETCH_BOUND)) {
            $assets[$counter] = ['id' => $id, 'roomId' => $roomdId, 'name' => $name];
            $counter++;
        }

        return $assets;
    }

    private function validateName ($name) {
        if (!is_string($name)) {
            throw new \InvalidArgumentException("Name moet een string bevatten");
        }
    }
}