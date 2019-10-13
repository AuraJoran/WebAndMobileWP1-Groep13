<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Model\AssetModel;

class AssetController extends AbstractController
{
    private $assetModel;

    public function __construct(AssetModel $assetModel)
    {
        $this->assetModel = $assetModel;
    }

    /**
     * @Route("/assets/{name}", name="getAssetByName")
     */
    public function findAssetByName($name)
    {
        $statuscode = 200;
        $asset = null;

        try {
            $asset = $this->assetModel->findAssetByName($name);
            if ($asset == null){
                $statuscode = 404;
            }
        } catch (\InvalidArgumentException $exception) {
            $statuscode = 400;
        } catch (\PDOException $exception) {
            $statuscode = 500;
        }

        return new JsonResponse($asset, $statuscode);
    }
}
