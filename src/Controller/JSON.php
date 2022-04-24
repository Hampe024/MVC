<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class jsonController
{
    /**
     * @Route("/card/api/deck", name="card-api-deck")
     */
    public function cardApiDeck(
        SessionInterface $session
    ): Response {
        if ($session->has("deck")) { # deck in session
            $deck = $session->get("deck");
        } else {
            $deck = new \App\card\Deck();
        }

        $data = [];
        foreach ($deck->cards as $card) {
            array_push($data, $card);
        }


        return new JsonResponse($data);
    }
}
