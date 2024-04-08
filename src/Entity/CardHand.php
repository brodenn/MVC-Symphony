<?php

namespace App\Entity;

class CardHand {
    private $cards = [];

    public function addCard(Card $card) {
        $this->cards[] = $card;
    }

    public function getCards() {
        return $this->cards;
    }
}
