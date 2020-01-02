<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Model\AssetModel;
use Symfony\Component\HttpFoundation\Request;

class AssetController extends Controller
{
    private $assetModel;

    public function __construct(AssetModel $assetModel)
    {
        $this->assetModel = $assetModel;
    }

    /**
     * @Route("/asset", name="getAssetByName")
     */
    public function findAssetByName(Request $request)
    {
        $statuscode = 200;
        $name = $request->query->get("naam");
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

    /**
     * @Route("/assets", name="getAssetByRoom")
     */
    public function findAssetByRoom(Request $request)
    {
        $statuscode = 200;
        $name = $request->query->get("room");
        $assets = null;

        try {
            $assets = $this->assetModel->findAssetsByRoom($name);
            if ($assets == null){
                $statuscode = 404;
            }
        } catch (\InvalidArgumentException $exception) {
            $statuscode = 400;
        } catch (\PDOException $exception) {
            $statuscode = 500;
        }

        return new JsonResponse($assets, $statuscode);
    }
}
