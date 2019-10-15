<?php

namespace App\Model;

use App\Model\PDOAssetModel;

class PDOTicketModel implements TicketModel {


    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function findTicketsByAssetName($assetName)
    {
        $pdo = $this->connection->getPDO();
        $statement = $pdo->prepare('SELECT * FROM tickets WHERE assetId = (SELECT assetId FROM assets WHERE name=:name)');
        $statement->bindParam(':name', $assetName, \PDO::PARAM_STR);
        $statement->execute();
        $statement->bindColumn(1, $id, \PDO::PARAM_INT);
        $statement->bindColumn(2, $assetId, \PDO::PARAM_INT);
        $statement->bindColumn(3, $numberOfVotes, \PDO::PARAM_INT);
        $statement->bindColumn(4, $description, \PDO::PARAM_STR);
        $tickets = null;
        if ($statement->fetch(\PDO::FETCH_BOUND)) {
            $tickets = ['id' => $id, 'assetId' => $assetId, 'numberOfVotes' => $numberOfVotes, 'description' => $description];
        }
        return $tickets;
    }
}