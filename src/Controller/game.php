<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class game extends AbstractController
{
    /**
     * @Route("/game/description", name="game")
     */
    public function gameDescription(): Response
    {
        return $this->render('game/description.html.twig');
    }

    /**
     * @Route(
    *       "/game/play",
    *       name="game-play"),
    *       methods={"GET","HEAD"}
     */
    public function gamePlay(): Response
    {
        // $data = [
        //     "draw5" => $this->generateUrl('card-deck-draw-amount', ['cardNumb' => 5,]),
        //     "draw2Player3Cards" => $this->generateUrl('card-deck-draw-player-amount', ["playerNumb" => 2, 'cardNumb' => 5])
        //     ];   , $data
        return $this->render('game/play.html.twig');
    }

    /**
     * @Route(
    *       "/game/doc",
    *       name="game-doc"),
    *       methods={"GET","HEAD"}
     */
    public function gameDoc(): Response
    {
        // $data = [
        //     "draw5" => $this->generateUrl('card-deck-draw-amount', ['cardNumb' => 5,]),
        //     "draw2Player3Cards" => $this->generateUrl('card-deck-draw-player-amount', ["playerNumb" => 2, 'cardNumb' => 5])
        //     ];   , $data
        return $this->render('game/doc.html.twig');
    }


}
