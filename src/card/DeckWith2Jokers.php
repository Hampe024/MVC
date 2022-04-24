<?php

namespace App\card;

class DeckWith2Jokers extends Deck{

    public function __construct() {
        for($color = 0; $color < 4; $color ++) {
            for($value = 0; $value < 14; $value ++) {
                array_push($this->cards, new \App\card\Card($color, $value));
            }
        }
        array_push($this->cards, new \App\card\Card(0, 14));
        array_push($this->cards, new \App\card\Card(0, 14));
    }
}