<?php

namespace App\Controller;

use App\Entity\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CardGameApiController extends AbstractController
{
    #[Route("/api/deck", name: "api_deck", methods: ["GET"])]
    public function getDeck(SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck', new DeckOfCards());
        $session->set('deck', $deck);

        $cards = [];
        foreach ($deck->getCards() as $card) {
            $cards[] = [
                'suit' => $card->getSuit(),
                'value' => $card->getValue(),
            ];
        }

        return new JsonResponse(['cards' => $cards]);
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle", methods: ["GET"])]
    public function shuffleDeck(SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck', new DeckOfCards());
        $deck->shuffle();
        $session->set('deck', $deck);

        $cards = array_map(function ($card) {
            return ['suit' => $card->getSuit(), 'value' => $card->getValue()];
        }, $deck->getCards());

        return new JsonResponse(['message' => 'Deck shuffled', 'cards' => $cards]);
    }


    #[Route("/api/deck/draw", name: "api_deck_draw", methods: ["GET"])]
    #[Route("/api/deck/draw/{number}", name: "api_deck_draw_number", methods: ["GET"], requirements: ["number" => "\d+"])]
    public function drawCards(SessionInterface $session, int $number = 1): JsonResponse
    {
        $deck = $session->get('deck', new DeckOfCards());
        $drawnCards = $deck->draw($number);
        $session->set('deck', $deck);

        $cards = [];
        foreach ($drawnCards as $card) {
            $cards[] = [
                'suit' => $card->getSuit(),
                'value' => $card->getValue(),
            ];
        }

        return new JsonResponse([
            'drawnCards' => $cards,
            'remaining' => count($deck->getCards()),
        ]);
    }


    #[Route("/api/deck/deal/{players}/{cards}", name: "api_deck_deal", methods: ["GET"], requirements: ["players" => "\d+", "cards" => "\d+"])]
    public function dealCards(SessionInterface $session, int $players, int $cards): JsonResponse
    {
        $deck = $session->get('deck', new DeckOfCards());
        $dealtCards = [];

        if (count($deck->getCards()) < $players * $cards) {
            return new JsonResponse(['error' => 'Not enough cards in the deck'], JsonResponse::HTTP_BAD_REQUEST);
        }

        for ($i = 0; $i < $players; $i++) {
            $playerCards = [];
            for ($j = 0; $j < $cards; $j++) {
                $drawnCard = $deck->draw(1);
                $playerCards[] = ['suit' => $drawnCard[0]->getSuit(), 'value' => $drawnCard[0]->getValue()];
            }
            $dealtCards["player" . ($i + 1)] = $playerCards;
        }

        $session->set('deck', $deck);

        return new JsonResponse(['dealtCards' => $dealtCards, 'remaining' => count($deck->getCards())]);
    }



}
