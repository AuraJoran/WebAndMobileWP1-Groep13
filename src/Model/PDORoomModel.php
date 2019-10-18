<?php

namespace App\Model;

class PDORoomModel implements RoomModel {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function findRoomByName($name)
    {
        $this->validateName($name);
        $pdo = $this->connection->getPDO();
        $statement = $pdo->prepare('SELECT * FROM rooms WHERE name=:name');
        $statement->bindParam(':name', $name, \PDO::PARAM_STR);
        $statement->execute();
        $statement->bindColumn(1, $id, \PDO::PARAM_INT);
        $statement->bindColumn(2, $name, \PDO::PARAM_STR);
        $statement->bindColumn(3, $happinessScore, \PDO::PARAM_INT);
        $room = null;
        if ($statement->fetch(\PDO::FETCH_BOUND)) {
            $room = ['id' => $id, 'name' => $name, 'happinessScore' => $happinessScore];
        }
        return $room;
    }

    public function findRoomsWithLesserHappinessScore ($happinessScore)
    {
        $this->validateHappinessScore($happinessScore);
        $pdo = $this->connection->getPDO();
        $statement = $pdo->prepare('SELECT * FROM rooms WHERE happinessScore < :score');
        $statement->bindParam(':score', $happinessScore, \PDO::PARAM_INT);
        $statement->execute();
        $statement->bindColumn(1, $id, \PDO::PARAM_INT);
        $statement->bindColumn(2, $name, \PDO::PARAM_STR);
        $statement->bindColumn(3, $happinessScore, \PDO::PARAM_INT);
        $rooms = [];
        $counter = 0;
        while ($statement->fetch(\PDO::FETCH_BOUND)) {
            $rooms[$counter] = ['id' => $id, 'name' => $name, 'happinessScore' => $happinessScore];
            $counter++;
        }
        return $rooms;
    }

    private function validateName ($name) {
        if (!is_string($name)) {
            throw new \InvalidArgumentException("Name moet een string bevatten");
        }
    }

    private function validateHappinessScore($happinessScore) {
        if (!(is_string($happinessScore) && preg_match("/^[0-9]+$/", $happinessScore))) {
            throw new \InvalidArgumentException("Happinessscore moet een int bevatten");
        }
    }
}