<?php

namespace App\Controller;

use App\Model\TicketModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Model\AssetModel;
use Symfony\Component\HttpFoundation\Request;

class AssetController extends Controller
{
    private $assetModel;
    private $ticketModel;

    public function __construct(AssetModel $assetModel, TicketModel $ticketModel)
    {
        $this->assetModel = $assetModel;
        $this->ticketModel = $ticketModel;
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

    /**
     * @Route("/assetsWithTickets", name="getAllAssetsWithTickets")
     */
    public function getAllAssetsWithTickets(Request $request)
    {
        $statuscode = 200;
        $assets = [];
        $tickets = null;
        $ticket = null;
        try {
            $tickets = $this->ticketModel->findAllTicketsGrouped();
            for ($i = 0; $i < count($tickets); $i++){
                $ticket = (object) $tickets[$i];
                array_push($assets, $this->assetModel->findAssetById($ticket->assetId));
            }
            if ($tickets == null || $assets == null) {
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
