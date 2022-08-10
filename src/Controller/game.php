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

        $game = new \App\game\Game();

        $player1 = $game->get_player(1);



        $player1 = $game->initiate_round($player1);
        echo $player1->cards[1]->value;

        $data = [
            "cards" => $game->deck->print_cards(),
            "player_cards" => $player1->print_cards()
            ];
        return $this->render('game/play.html.twig', $data);
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
