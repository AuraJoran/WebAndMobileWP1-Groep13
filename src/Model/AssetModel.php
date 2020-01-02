<?php

namespace App\Model;

interface AssetModel
{
    public function findAssetByName($name);
    public function findAssetsByRoom($roomId);
}