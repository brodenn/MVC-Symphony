<?php
// src/Entity/CardGraphic.php

namespace App\Entity;

class CardGraphic extends Card {
    // Mapping Unicode characters to card suits and values
    private static $unicodeMap = [
        'Spades' => [
            'A' => '🂡', '2' => '🂢', '3' => '🂣', '4' => '🂤', '5' => '🂥',
            '6' => '🂦', '7' => '🂧', '8' => '🂨', '9' => '🂩', '10' => '🂪',
            'J' => '🂫', 'Q' => '🂭', 'K' => '🂮'
        ],
        'Hearts' => [
            'A' => '🂱', '2' => '🂲', '3' => '🂳', '4' => '🂴', '5' => '🂵',
            '6' => '🂶', '7' => '🂷', '8' => '🂸', '9' => '🂹', '10' => '🂺',
            'J' => '🂻', 'Q' => '🂽', 'K' => '🂾'
        ],
        'Diamonds' => [
            'A' => '🃁', '2' => '🃂', '3' => '🃃', '4' => '🃄', '5' => '🃅',
            '6' => '🃆', '7' => '🃇', '8' => '🃈', '9' => '🃉', '10' => '🃊',
            'J' => '🃋', 'Q' => '🃍', 'K' => '🃎'
        ],
        'Clubs' => [
            'A' => '🃑', '2' => '🃒', '3' => '🃓', '4' => '🃔', '5' => '🃕',
            '6' => '🃖', '7' => '🃗', '8' => '🃘', '9' => '🃙', '10' => '🃚',
            'J' => '🃛', 'Q' => '🃝', 'K' => '🃞'
        ],
        'Joker' => [
            'Black' => '🃏', // Playing Card Black Joker
            'Red' => '🂿', // Playing Card Red Joker
            'White' => '🃟' // Playing Card White Joker
        ]
    ];

    public function getSymbol(): string {
        $suit = $this->getSuit();
        $value = $this->getValue();

        if ($value === 'Joker') {
            return self::$unicodeMap['Joker'][$suit];
        }

        return self::$unicodeMap[$suit][$value];
    }

    public function __toString() {
        // Uses getSymbol() to return the Unicode character for the card
        return $this->getSymbol();
    }
}
