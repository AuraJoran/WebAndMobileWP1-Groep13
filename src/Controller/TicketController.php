<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Model\TicketModel;
use Symfony\Component\HttpFoundation\Request;

class TicketController extends Controller
{
    private $ticketModel;

    public function __construct(TicketModel $ticketModel)
    {
        $this->ticketModel = $ticketModel;
    }

    /**
     * @Route("/tickets", methods={"GET"}, name="getTicketsByAssetName")
     */
    public function findTicketsByAssetName(Request $request)
    {
        $statuscode = 200;
        $assetName = $request->query->get("assetName");
        $tickets = null;

        try {
            $tickets = $this->ticketModel->findTicketsByAssetName($assetName);
            if ($tickets == null){
                $statuscode = 404;
            }
        } catch (\InvalidArgumentException $exception) {
            $statuscode = 400;
        } catch (\PDOException $exception) {
            $statuscode = 500;
        }

        return new JsonResponse($tickets, $statuscode);
    }

    /**
     * @Route("/tickets/add", methods={"GET"}, name="addNumberOfVotesByOne")
     */
    public function AddNumberOfVotesByOne(Request $request) {
        $statuscode = 200;
        $id = $request->query->get('id');

        try {
            $this->ticketModel->addNumberOfVotesByOne($id);
        } catch (\InvalidArgumentException $exception) {
            $statuscode = 400;
        } catch (\PDOException $exception) {
            $statuscode = 500;
        }

        return new JsonResponse("Done!", $statuscode);
    }

}
