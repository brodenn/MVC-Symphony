<?php


namespace App\Entity;

class CardGraphic extends Card
{
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
            'Black' => '🃏',
            'Red' => '🂿',
            'White' => '🃟'
        ]
    ];

    public function getSymbol(): string
    {
        $suit = $this->getSuit();
        $value = $this->getValue();

        if ($value === 'Joker') {
            return self::$unicodeMap['Joker'][$suit];
        }

        return self::$unicodeMap[$suit][$value];
    }

    public function __toString()
    {
        return $this->getSymbol();
    }
}
