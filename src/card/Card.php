<?php

namespace App\card;

class Card
{
    public $color;
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

    public function __construct($color, $value)
    {
        $this->color = $color;
        $this->value = $value;
    }

    public function getAsString(): string
    {
        return $this->cards[$this->value][$this->color];
    }
}
