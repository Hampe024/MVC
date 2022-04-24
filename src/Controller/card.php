<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class card extends AbstractController
{
    /**
     * @Route(
    *       "/card",
    *       name="card"),
    *       methods={"GET","HEAD"}
     */
    public function cardHome(): Response
    {
        $data = [
            "draw5" => $this->generateUrl('card-deck-draw-amount', ['cardNumb' => 5,]),
            "draw2Player3Cards" => $this->generateUrl('card-deck-draw-player-amount', ["playerNumb" => 2, 'cardNumb' => 5])
            ];
        return $this->render('card/card.html.twig', $data);
    }

    /**
     * @Route(
    *       "/card/deck",
    *       name="card-deck")
     */
    public function cardDeck(
        SessionInterface $session,
        Request $request
    ): Response {
        $debug = "deck";

        if ($request->request->has("newDeck")) {
            $deck = new \App\card\Deck();
            $session->set("deck", $deck);
            $deck = $deck->print_cards();
            $debug = "deck new deck";
        } else {
            if ($session->has("deck")) { # deck in session
                $deck = $session->get("deck")->print_cards();
                $debug = "deck in sess";
            } else { # deck not in session
                $deck = new \App\card\Deck();
                $session->set("deck", $deck);
                $deck = $deck->print_cards();
                $debug = "deck not sess";
            }
        }

        $data = [
            "cards" => $deck,
            "debug" => $debug,
            "newDeck" => "h",
            "draw5" => $this->generateUrl('card-deck-draw-amount', ['cardNumb' => 5,]),
            "draw2Player3Cards" => $this->generateUrl('card-deck-draw-player-amount', ["playerNumb" => 2, 'cardNumb' => 5])
            ];
        return $this->render('card/card.html.twig', $data);
    }

    /**
     * @Route(
    *       "/card/deck/shuffle",
    *       name="card-deck-shuffle")
     */
    public function cardDeckShuffle(
        SessionInterface $session,
        Request $request
    ): Response {
        $debug = "shuffle";
        if ($request->request->has("reShuffle")) {
            $deck = $session->get("deck");
            $deck->shuffler();
            $debug = "shuffle in sess";
        } else {
            if ($session->has("deck")) { # deck in session
                $deck = $session->get("deck");
                $debug = "shuffle in sess noShuff";
            } else { # deck not in session
                $deck = new \App\card\Deck();
                $session->set("deck", $deck);
                $debug = "shuffle not sess";
            }
        }

        $data = [
            "cards" => $deck->print_cards(),
            "debug" => $debug,
            "reShuffle" => "h",
            "draw5" => $this->generateUrl('card-deck-draw-amount', ['cardNumb' => 5,]),
            "draw2Player3Cards" => $this->generateUrl('card-deck-draw-player-amount', ["playerNumb" => 2, 'cardNumb' => 5])
            ];
        return $this->render('card/card.html.twig', $data);
    }

    /**
     * @Route(
    *       "/card/deck/draw",
    *       name="card-deck-draw")
     */
    public function cardDeckDraw(
        SessionInterface $session,
        Request $request
    ): Response {
        $debug = "draw";

        if ($request->request->has("newDeck")) {
            $deck = new \App\card\Deck();
            $session->set("deck", $deck);
            $debug = "draw new deck";
            $drawCard = "🂠";
        } elseif ($request->request->has("newDraw")) {
            $deck = $session->get("deck");
            $drawCard = $deck->draw()->getAsString();
            $debug = "draw in sess";
        } else {
            if ($session->has("deck")) { # deck in session
                $deck = $session->get("deck");
                $debug = "draw in sess";
            } else { # deck not in session
                $deck = new \App\card\Deck();
                $session->set("deck", $deck);
                $debug = "draw not sess";
            }
            $drawCard = "🂠";
        }

        $data = [
            "cards" => $deck->print_cards(),
            "debug" => $debug ?? "default debug",
            "drawCard" => [$drawCard],
            "newDeck" => "h",
            "newDraw" => "h",
            "draw5" => $this->generateUrl('card-deck-draw-amount', ['cardNumb' => 5,]),
            "draw2Player3Cards" => $this->generateUrl('card-deck-draw-player-amount', ["playerNumb" => 2, 'cardNumb' => 5])
            ];
        return $this->render('card/card.html.twig', $data);
    }

    /**
     * @Route(
    *       "/card/deck/draw/{cardNumb}",
    *       name="card-deck-draw-amount")
     */
    public function cardDeckDrawAmount(
        SessionInterface $session,
        Request $request,
        int $cardNumb
    ): Response {
        $debug = "deck";

        if ($request->request->has("newDeck")) {
            $deck = new \App\card\Deck();
            $session->set("deck", $deck);
            $debug = "draw new deck";
            $drawCard = [];
            for ($i = 0; $i <= $cardNumb; $i ++) {
                array_push($drawCard, "🂠");
            }
        }

        if ($request->request->has("newDraw")) {
            $deck = $session->get("deck");
            if ($cardNumb > $deck->amount()) {
                $drawCard = [];
                for ($i = 0; $i <= $cardNumb; $i ++) {
                    array_push($drawCard, "🂠");
                }
                $this->addFlash("cardKeyError", "You can not draw $cardNumb from the deck");
            } else {
                $drawCard = [];
                for ($i = 0; $i <= $cardNumb; $i ++) {
                    array_push($drawCard, $deck->draw()->getAsString());
                }
            }
            $debug = "draw in sess";
        } else {
            if ($session->has("deck")) { # deck in session
                $deck = $session->get("deck");
                $debug = "draw in sess";
            } else { # deck not in session
                $deck = new \App\card\Deck();
                $session->set("deck", $deck);
                $debug = "draw not sess";
            }
            $drawCard = [];
            for ($i = 0; $i <= $cardNumb; $i ++) {
                array_push($drawCard, "🂠");
            }
        }

        $data = [
            "cards" => $deck->print_cards(),
            "debug" => $debug ?? "default debug",
            "drawCard" => $drawCard,
            "newDeck" => "h",
            "newDraw" => "h",
            "draw5" => $this->generateUrl('card-deck-draw-amount', ['cardNumb' => 5,]),
            "draw2Player3Cards" => $this->generateUrl('card-deck-draw-player-amount', ["playerNumb" => 2, 'cardNumb' => 5])
            ];
        return $this->render('card/card.html.twig', $data);
    }

    /**
     * @Route(
    *       "/card/deck/draw/{playerNumb}/{cardNumb}",
    *       name="card-deck-draw-player-amount")
     */
    public function cardDeckDrawPlayerAmount(
        SessionInterface $session,
        Request $request,
        int $playerNumb,
        int $cardNumb
    ): Response {
        $debug = "deck players";
        $deck = $session->get("deck") ?? new \App\card\deck();

        $players = [];
        for ($i = 0; $i < $playerNumb; $i ++) {
            array_push($players, new \App\card\Player());
            for ($j = 0; $j < $cardNumb; $j ++) {
                $players[$i]->give_card($deck->draw());
            }
        }

        $printable_players = [];
        foreach ($players as $player) {
            foreach ($player->hand->cards as $card) {
                array_push($printable_players, $card->getAsString());
            }
            array_push($printable_players, "\n");
        }




        if ($request->request->has("newDeck")) {
            $deck = new \App\card\Deck();
            $session->set("deck", $deck);
            $debug = "draw new deck";
            $printable_players = [];
            foreach ($players as $player) {
                foreach ($player->hand->cards as $card) {
                    array_push($printable_players, "🂠");
                }
                array_push($printable_players, "\n");
            }
        }





        $data = [
            "cards" => $deck->print_cards(),
            "debug" => $debug ?? "default debug",
            "drawCard" => $printable_players,
            "newDeck" => "h",
            "newDraw" => "h",
            "players" => $players,
            "draw5" => $this->generateUrl('card-deck-draw-amount', ['cardNumb' => 5,]),
            "draw2Player3Cards" => $this->generateUrl('card-deck-draw-player-amount', ["playerNumb" => 2, 'cardNumb' => 5])
            ];
        return $this->render('card/card.html.twig', $data);
    }

    /**
     * @Route(
    *       "/card/deck2",
    *       name="card-deck-2")
     */
    public function cardDeck2(
        SessionInterface $session,
        Request $request
    ): Response {
        $debug = "deck";

        if ($request->request->has("newDeck")) {
            $deck = new \App\card\DeckWith2Jokers();
            $session->set("deck", $deck);
            $deck = $deck->print_cards();
            $debug = "deck new deck";
        } else {
            if ($session->has("deck")) { # deck in session
                $deck = $session->get("deck")->print_cards();
                $debug = "deck in sess";
            } else { # deck not in session
                $deck = new \App\card\Deck();
                $session->set("deck", $deck);
                $deck = $deck->print_cards();
                $debug = "deck not sess";
            }
        }

        $data = [
            "cards" => $deck,
            "debug" => $debug,
            "newDeck" => "h",
            "draw5" => $this->generateUrl('card-deck-draw-amount', ['cardNumb' => 5,]),
            "draw2Player3Cards" => $this->generateUrl('card-deck-draw-player-amount', ["playerNumb" => 2, 'cardNumb' => 5])
            ];
        return $this->render('card/card.html.twig', $data);
    }
}
