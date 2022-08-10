<?php

namespace App\game;

class Player
{

    public $cards;
    public $player_number;

    public function __construct($player_number)
    {
        $this->player_number = $player_number;
    }

    public function print_cards()
    {
        $str = "";
        foreach ($this->cards as $card) {
            $str .= $card->getAsString();
            $str .= " ";
        }
        return $str;
    }
}