<?php
// src/Entity/CardGraphic.php

namespace App\Entity;

class CardGraphic extends Card {

    public function getSymbol(): string {
        $suits = [
            'Hearts' => '♥',
            'Diamonds' => '♦',
            'Clubs' => '♣',
            'Spades' => '♠',
        ];

        $values = [
            'Jack' => 'J',
            'Queen' => 'Q',
            'King' => 'K',
            'Ace' => 'A',
        ];

        $suitSymbol = $suits[$this->getSuit()] ?? '';
        $valueSymbol = $values[$this->getValue()] ?? $this->getValue();

        return "{$valueSymbol}{$suitSymbol}";
    }
}
