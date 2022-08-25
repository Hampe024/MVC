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
    *       "/game/pvp",
    *       name="game-pvp"),
    *       methods={"GET","HEAD"}
     */
    public function gamePVP(
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
            for ($i = 0; $i < 2; $i ++)
            {
                $player = $game->draw_card($player);
                if ($player->has_new_ace())
                {
                    $session->set("current_player", $player->player_number);
                    $session->set("game", $game);
                    return $this->render('game/checkAce.html.twig', $player->get_ace_data());
                }
            }
        }
        else {
            $game = $session->get("game");
            $player = $game->get_player($session->get("current_player"));
        }

        if ($request->request->has("ace_1"))
        {
            $player->make_ace_value(1);
        }
        else if ($request->request->has("ace_14"))
        {
            $player->make_ace_value(14);
        }
        


        if ($request->request->has("newCard"))
        {
            $player = $game->draw_card($player);
        }



        if ($player->print_card_sum() > 21)
        {
            $new_card_button = False;
        }
        else {
            $new_card_button = True;
        }


        

        if ($player->has_new_ace())
        {
            return $this->render('game/checkAce.html.twig', $player->get_ace_data());
        }


        if ($request->request->has("done"))
        {
            if ($player->player_number === 2)   // game over
            {
                if ($game->player1->print_card_sum() > $game->player2->print_card_sum())    // player 1 wins
                {
                    $game_over =
                    "Player 1 wins with " . $game->player1->print_card_sum() .
                    " to " . $game->player2->print_card_sum();
                }
                else    // player 2 wins
                {
                    $game_over = 
                    "Player 2 wins with " . $game->player2->print_card_sum() .
                    " to " . $game->player1->print_card_sum();
                }
                
            }
            else
            {
                $player = $game->get_player(2);
                for ($i = 0; $i < 2; $i ++)
                {
                    $player = $game->draw_card($player);
                    if ($player->has_new_ace())
                    {
                        $session->set("current_player", $player->player_number);
                        $session->set("game", $game);
                        return $this->render('game/checkAce.html.twig', $player->get_ace_data());
                    }
                }
                $new_card_button = True;
            }
        }



        $session->set("current_player", $player->player_number);
        $session->set("game", $game);
        $data = [
            "cards" => $game->deck->print_cards(),
            "player_cards" => $player->print_cards(),
            "player_cards_sum" => $player->print_card_sum(),
            "game_over" => $game_over ?? "",
            "new_card_button" => $new_card_button,
            "debug" => count($player->cards),
            "debug2" => $session->get("current_player")
            ];
        return $this->render('game/play.html.twig', $data);
    }

    /**
     * @Route(
    *       "/game/pve",
    *       name="game-pve"),
    *       methods={"GET","HEAD"}
     */
    public function gamePVE(
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
            for ($i = 0; $i < 2; $i ++)
            {
                $player = $game->draw_card($player);
                if ($player->has_new_ace())
                {
                    $session->set("current_player", $player->player_number);
                    $session->set("game", $game);
                    return $this->render('game/checkAce.html.twig', $player->get_ace_data());
                }
            }
        }
        else {
            $game = $session->get("game");

            if ($request->request->has("getResult")) // player is bot
            {
                $player = $game->get_player(2);
                for ($i = 0; $i < 2; $i ++)
                {
                    $player = $game->draw_card($player);
                    if ($player->has_new_ace())
                    {
                        $player->make_ace_value(1);
                    }
                }
                while ($player->print_card_sum() < 17)
                {
                    $player = $game->draw_card($player);
                    if ($player->has_new_ace())
                    {
                        $player->make_ace_value(1);
                    }
                }
                if ($game->player1->print_card_sum() > $game->player2->print_card_sum())    // player 1 wins
                {
                    $game_over =
                    "Player 1 wins with " . $game->player1->print_card_sum() .
                    " to " . $game->player2->print_card_sum();
                }
                else    // player 2 wins
                {
                    $game_over = 
                    "Player 2 wins with " . $game->player2->print_card_sum() .
                    " to " . $game->player1->print_card_sum();
                }
                $data = [
                    "player_data" => [
                        "p2" => [
                            "cards" => $game->get_player(2)->print_cards(),
                            "cards_sum" => $game->get_player(2)->print_card_sum(),
                            "class_name" => "2"
                            ],
                        "p1" => [
                            "cards" => $game->get_player(1)->print_cards(),
                            "cards_sum" => $game->get_player(1)->print_card_sum(),
                            "class_name" => "1"
                            ]
                    ],
                    "game_over" => $game_over ?? "no game over"
                    ];
                return $this->render('game/showResult.html.twig', $data);
            }
            else
            {
                $player = $game->get_player(1);

                if ($request->request->has("ace_1"))
                {
                    $player->make_ace_value(1);
                }
                else if ($request->request->has("ace_14"))
                {
                    $player->make_ace_value(14);
                }
                


                if ($request->request->has("newCard"))
                {
                    $player = $game->draw_card($player);
                }



                if ($player->print_card_sum() > 21)
                {
                    $new_card_button = False;
                }
                else {
                    $new_card_button = True;
                }


                

                if ($player->has_new_ace())
                {
                    return $this->render('game/checkAce.html.twig', $player->get_ace_data());
                }


                if ($request->request->has("done"))
                {
                    $session->set("game", $game);
                    $data = [
                        "result_button" => $result_button ?? False
                        ];
                    return $this->render('game/play.html.twig', $data);
                }
    
            }




           
            
        }

        
        $session->set("game", $game);
        $data = [
            "cards" => $game->deck->print_cards(),
            "player_cards" => $player->print_cards(),
            "player_cards_sum" => $player->print_card_sum(),
            "game_over" => $game_over ?? "",
            "new_card_button" => $new_card_button ?? True,
            "debug" => count($player->cards),
            "debug2" => $player->player_number
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
