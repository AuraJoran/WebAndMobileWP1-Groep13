<?php

namespace App\Model;

use App\Model\PDOAssetModel;

class PDOTicketModel implements TicketModel {


    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function findTicketsByAssetName($assetName)
    {
        $this->validateAssetName($assetName);
        $pdo = $this->connection->getPDO();
        $statement = $pdo->prepare('SELECT * FROM tickets WHERE assetId = (SELECT id FROM assets WHERE name =:name)');
        $statement->bindParam(':name', $assetName, \PDO::PARAM_STR);
        $statement->execute();
        $statement->bindColumn(1, $id, \PDO::PARAM_INT);
        $statement->bindColumn(2, $assetId, \PDO::PARAM_INT);
        $statement->bindColumn(3, $numberOfVotes, \PDO::PARAM_INT);
        $statement->bindColumn(4, $description, \PDO::PARAM_STR);
        $tickets = [];
        $counter = 0;
        while ($statement->fetch(\PDO::FETCH_BOUND)) {
            $tickets[$counter] = ['id' => $id, 'assetId' => $assetId, 'numberOfVotes' => $numberOfVotes, 'description' => $description];
            $counter++;
        }
        return $tickets;
    }

    public function addNumberOfVotesByOne($id) {
        $this->validateId($id);
        $pdo = $this->connection->getPDO();
        $statement = $pdo->prepare('UPDATE tickets SET numberOfVotes = numberOfVotes + 1 WHERE id =:id');
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    private function validateId($id) {
        if (!(is_string($id) && preg_match("/^[0-9]+$/", $id) && (int)$id > 0)) {
            throw new \InvalidArgumentException("Id moet een int > 0 bevatten");
        }
    }

    private function validateAssetName($assetName) {
        if (!is_string($assetName)) {
            throw new \InvalidArgumentException("AssetName moet een string bevatten");
        }
    }
}