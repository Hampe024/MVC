<?php

namespace App\card;

class Card
{
    public $x;
    public $y;
    public $value;
    protected $cards = [
        ["🂡", "🂱", "🃁", "🃑"],
        ["🂢", "🂲", "🃂", "🃒"],
        ["🂣", "🂳", "🃃", "🃓"],
        ["🂤", "🂴", "🃄", "🃔"],
        ["🂥", "🂵", "🃅", "🃕"],
        ["🂦", "🂶", "🃆", "🃖"],
        ["🂧", "🂷", "🃇", "🃗"],
        ["🂨", "🂸", "🃈", "🃘"],
        ["🂩", "🂹", "🃉", "🃙"],
        ["🂪", "🂺", "🃊", "🃚"],
        ["🂫", "🂻", "🃋", "🃛"],
        ["🂭", "🂽", "🃍", "🃝"],
        ["🂮", "🂾", "🃎", "🃞"],
        ["🂿"]
    ];

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
        if ($y === 0) // card is ace, player decides value
        {
            $this->value = 0;
        }
        else
        {
            $this->value = $y + 1;
        }
    }

    public function getAsString(): string
    {
        return $this->cards[$this->y][$this->x];
    }
}
