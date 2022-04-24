<?php

namespace App\card;

class Player
{
    public $hand = null;

    public function __construct()
    {
        $this->hand = new \App\card\CardHand();
    }

    public function give_card(object $card)
    {
        $this->hand->add_card($card);
    }

    public function show_cards()
    {
        return $this->hand->show_cards();
    }

    public function print_cards()
    {
        $str = "";
        foreach ($this->hand as $card) {
            $str .= $card->getAsString();
        }
        return $this->hand->print_cards();
    }
}
