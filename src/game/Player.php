<?php

namespace App\game;

class Player
{

    public $cards = [];
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

    public function print_card_sum()
    {
        $int = 0;
        foreach ($this->cards as $card) {
            $int += $card->value;
        }
        return $int;
    }

    public function has_new_ace()
    {
        foreach ($this->cards as $card)
        {
            if($card->value === 0)
            {
                return True;
            }
        }
        return False;
    }

    public function get_ace_data() 
    {
        $data = [
            "card" => mb_substr($this->print_cards(), -2),
            "player_cards" => $this->print_cards(),
            "player_cards_sum" => $this->print_card_sum()
        ];
        return $data;
    }

    public function make_ace_value($value)
    {
        $this->cards[count($this->cards)-1]->value = $value;
    }
}