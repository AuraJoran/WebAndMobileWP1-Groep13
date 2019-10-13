<?php

namespace App\Model;

class PDORoomModel implements RoomModel {
    
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function findRoomByName($name)
    {
        $pdo = $this->connection->getPDO();
        $statement = $pdo->prepare('SELECT * FROM rooms WHERE name=:name');
        $statement->bindParam(':name', $name, \PDO::PARAM_STR);
        $statement->execute();
        $statement->bindColumn(1, $id, \PDO::PARAM_INT);
        $statement->bindColumn(2, $name, \PDO::PARAM_STR);
        $statement->bindColumn(3, $happinessscore, \PDO::PARAM_INT);
        $room = null;
        if ($statement->fetch(\PDO::FETCH_BOUND)) {
            $room = ['id' => $id, 'name' => $name, 'happinessScore' => $happinessscore];
        }
        return $room;
    }
}