<?php

namespace App\Entity;

class DeckOfCards
{
    private $cards = [];

    public function __construct()
    {
        $suits = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = new CardGraphic($suit, $value);
            }
        }
    }


    public function shuffle()
    {
        shuffle($this->cards);
    }

    public function draw($number = 1)
    {
        return array_splice($this->cards, 0, $number);
    }

    public function getCards()
    {
        return $this->cards;
    }

    public function dealCards(int $players, int $cardsPerPlayer)
    {
        $dealtCards = [];
        for ($i = 0; $i < $players; $i++) {
            $dealtCards[$i] = $this->draw($cardsPerPlayer);
        }
        return $dealtCards;
    }

    public function toString(): string
    {
        $output = [];
        foreach ($this->cards as $card) {
            $output[] = (string)$card;
        }
        return implode(', ', $output);
    }


}
