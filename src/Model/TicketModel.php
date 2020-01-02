<?php

namespace App\Model;

interface TicketModel
{
    public function findTicketsByAssetName($assetName);
    public function addNumberOfVotesByOne($id);
    public function findAllTicketsGrouped();
    public function isResolved($id);
}