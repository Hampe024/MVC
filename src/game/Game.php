<?php

namespace App\game;

class Game
{

    public $player1;
    public $player2;
    public $deck;

    public function __construct()
    {
        $this->deck = new \App\card\Deck();
        $this->player1 = new \App\game\Player(1);
        $this->player2 = new \App\game\Player(2);
    }

    public function get_player($numb)
    {
        if ($numb === 1)
        {
            return $this->player1;
        }
        return $this->player2;
    }

    public function initiate_round($player)
    {
        $player->cards = [$this->deck->draw(), $this->deck->draw()];

        return $player;
    }
}