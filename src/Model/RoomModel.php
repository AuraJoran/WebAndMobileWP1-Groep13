<?php

namespace App\Model;

interface RoomModel
{
    public function findRoomByName($name);
    public function findRoomsWithLesserHappinessScore($score);
}