<?php

namespace App\card;

class Deck
{
    public $cards = [];

    public function __construct()
    {
        for ($color = 0; $color < 4; $color ++) {
            for ($value = 0; $value < 13; $value ++) {
                array_push($this->cards, new \App\card\Card($color, $value));
            }
        }
    }

    public function shuffler()
    {
        shuffle($this->cards);
    }

    public function amount()
    {
        return count($this->cards);
    }

    public function draw()
    {
        $numb = rand(0, ($this->amount()-1));
        $drawCard = $this->cards[$numb];
        \array_splice($this->cards, $numb, 1);

        return $drawCard;
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
