<?php

namespace App\Model;

interface TicketModel
{
    public function findTicketsByAssetName($assetName);
}