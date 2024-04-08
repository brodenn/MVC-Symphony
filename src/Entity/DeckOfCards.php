<?php

namespace App\Entity;

class DeckOfCards {
    private $cards = [];

    public function __construct() {
        $suits = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King', 'Ace'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = new Card($suit, $value);
            }
        }
    }

    public function shuffle() {
        shuffle($this->cards);
    }

    public function draw($number = 1) {
        return array_splice($this->cards, 0, $number);
    }

    public function getCards() {
        return $this->cards;
    }
}
