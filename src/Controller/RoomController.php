<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Model\RoomModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Json;

class RoomController extends Controller
{
    private $roomModel;

    public function __construct(RoomModel $roomModel)
    {
        $this->roomModel = $roomModel;
    }

    /**
     * @Route("/rooms", methods={"GET"}, name="getRoomByName")
     */
    public function findRoomByName(Request $request)
    {
        $statuscode = 200;
        $name = $request->query->get('naam');
        $room = null;

        try {
            $room = $this->roomModel->findRoomByName($name);
            if ($room == null){
                $statuscode = 404;
            }
        } catch (\InvalidArgumentException $exception) {
            $statuscode = 400;
        } catch (\PDOException $exception) {
            $statuscode = 500;
        }

        return new JsonResponse("HappinessScore: " . $room["happinessScore"] , $statuscode);
    }

    /**
     * @Route("/rooms/max", methods={"GET"}, name="getRoomsWithLesserHappinessScore")
     */
    public function findRoomsWithLesserHappinessScore(Request $request)
    {
        $statuscode = 200;
        $score = $request->query->get('score');
        $rooms = null;

        try {
            $rooms = $this->roomModel->findRoomsWithLesserHappinessScore($score);
            if ($rooms == null){
                $statuscode = 404;
            }
        } catch (\InvalidArgumentException $exception) {
            $statuscode = 400;
        } catch (\PDOException $exception) {
            $statuscode = 500;
        }

        return new JsonResponse($rooms, $statuscode);
    }

}
