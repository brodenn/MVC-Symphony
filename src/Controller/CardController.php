<?php

namespace App\Controller;

use App\Entity\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/card/deck", name="card_deck")
     */
    public function deck(SessionInterface $session): Response
    {
        if (!$session->has('deck')) {
            $session->set('deck', new DeckOfCards());
        }

        /** @var DeckOfCards $deck */
        $deck = $session->get('deck');

        return $this->render('card/deck.html.twig', [
            'cards' => $deck->getCards(),
        ]);
    }

    /**
     * @Route("/card/deck/shuffle", name="card_deck_shuffle")
     */
    public function shuffle(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $deck->shuffle();

        $session->set('deck', $deck);

        return $this->redirectToRoute('card_deck');
    }

    /**
     * @Route("/card/deck/draw/{number}", name="card_deck_draw", defaults={"number": 1}, requirements={"number"="\d+"})
     */
    public function draw(SessionInterface $session, int $number): Response
    {
        /** @var DeckOfCards $deck */
        $deck = $session->get('deck', new DeckOfCards());

        $cardsDrawn = $deck->draw($number);

        return $this->render('card/draw.html.twig', [
            'cards' => $cardsDrawn,
        ]);
    }
}
