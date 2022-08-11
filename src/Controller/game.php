<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    public function gamePlay(
        SessionInterface $session,
        Request $request
    ): Response
    {
        if ($request->request->has("kill_sess"))
        {
            $session->clear();
        }

        if (!$session->has("game"))
        {
            $game = new \App\game\Game();
            $player = $game->get_player(1);
            $player = $game->initiate_round($player);
        }
        else {
            $game = $session->get("game");
            $player = $game->get_player($session->get("current_player"));
            $session->set("game", $game);
        }

        

        
        if ($request->request->has("newCard"))
        {
            $player = $game->draw_card($player);
        }

        if ($request->request->has("done"))
        {
            if ($player->player_number === 2)
            {
                if ($game->player1->print_card_sum() > $game->player2->print_card_sum())
                {
                    // player 1 wins
                    $game_over = "Player 1 wins with " . $game->player1->print_card_sum() . " to " . $game->player2->print_card_sum();
                }
                else
                {
                    // player 2 wins
                    $game_over = "Player 2 wins with " . $game->player2->print_card_sum() . " to " . $game->player1->print_card_sum();
                }
                
            }
            $player = $game->get_player($player->player_number + 1);
            $player = $game->initiate_round($player);
        }



        $session->set("current_player", $player->player_number);
        $session->set("game", $game);
        $data = [
            "cards" => $game->deck->print_cards(),
            "player_cards" => $player->print_cards(),
            "player_cards_sum" => $player->print_card_sum(),
            "game_over" => $game_over ?? "",
            "debug" => count($player->cards),
            "debug2" => $session->get("current_player")
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
