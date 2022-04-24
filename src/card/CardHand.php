<?php

namespace App\card;

class CardHand {
    public $cards = [];

    public function __construct() {
        
    }

    public function add_card(object $card) {
        array_push($this->cards, $card);
    }

    public function show_cards() {
        return $this->cards;
    }

    public function print_cards() {
        return $this->cards;
    }

}