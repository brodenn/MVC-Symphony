<?php

namespace App\Controller;

use App\Entity\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    #[Route("/card/deck", name: "card_deck")]
    public function deck(SessionInterface $session): Response
    {
        if (!$session->has('deck')) {
            $session->set('deck', new DeckOfCards());
        }

        $deck = $session->get('deck');

        return $this->render('card/deck.html.twig', [
            'cards' => $deck->getCards(),
        ]);
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffle(SessionInterface $session): Response
    {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set('deck', $deck);


        return $this->redirectToRoute('card_deck');
    }

    #[Route('/card/deck/draw/{number}', name: 'card_deck_draw', defaults: ['number' => 1], requirements: ['number' => '\d+'])]
    public function draw(SessionInterface $session, int $number = 1): Response
    {
        // Ensure a deck exists in the session; otherwise, create a new one
        $deck = $session->get('deck', new DeckOfCards());
        $deck->shuffle(); // Optionally shuffle before drawing, if needed

        $cardsDrawn = $deck->draw($number);
        $session->set('deck', $deck); // Save the modified deck back into the session

        return $this->render('card/draw.html.twig', [
            'cards' => $cardsDrawn,
            'remaining' => count($deck->getCards()), // Pass the remaining number of cards
        ]);
    }

    #[Route("/card/game", name: "card_game")]
    public function cardGame(): Response
    {
        return $this->render('card/game.html.twig');
    }

    #[Route('/card/deck/deal/{players}/{cards}', name: 'card_deck_deal', requirements: ['players' => '\d+', 'cards' => '\d+'])]
    public function deal(SessionInterface $session, int $players, int $cards): Response
    {
        $deck = $session->get('deck', new DeckOfCards());
        $dealtCards = $deck->dealCards($players, $cards);
        $session->set('deck', $deck); // Save the updated deck back to the session

        return $this->render('card/deal.html.twig', [
            'dealtCards' => $dealtCards,
            'remaining' => count($deck->getCards()),
        ]);
    }

}
