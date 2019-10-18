<?php

namespace App\Model;

interface TicketModel
{
    public function findTicketsByAssetName($assetName);
    public function findTicketById($id);
    public function addNumberOfVotesByOne($id);
}