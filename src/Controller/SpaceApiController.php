<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SpaceApiController extends AbstractController
{
    #[Route("/api/space/fact", name: "api_space_fact")]
    public function apiSpaceFact(): JsonResponse
    {
        $fact = "A random space fact";
        $data = ['fact' => $fact];

        return new JsonResponse($data);
    }

    #[Route("/api", name: "api_index")]
    public function apiIndex(): Response
    {
        $routes = [
            // Existing routes
            'space_fact' => [
                'url' => $this->generateUrl('api_space_fact', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'description' => 'Get a random space fact.'
            ],
            'quote' => [
                'url' => $this->generateUrl('api_quote', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'description' => 'Get a daily inspirational quote about space.'
            ],
            // New routes from CardGameApiController
            'deck_view' => [
                'url' => $this->generateUrl('api_deck', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'description' => 'View the current state of the deck.'
            ],
            'deck_shuffle' => [
                'url' => $this->generateUrl('api_deck_shuffle', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'description' => 'Shuffle the current deck.'
            ],
            'deck_draw' => [
                'url' => $this->generateUrl('api_deck_draw', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'description' => 'Draw one or more cards from the deck.'
            ],
            'deck_deal' => [
                'url' => $this->generateUrl('api_deck_deal', ['players' => 2, 'cards' => 3], UrlGeneratorInterface::ABSOLUTE_URL), // Example parameters
                'description' => 'Deal cards to a number of players.'
            ],
        ];

        return $this->render('api.html.twig', ['routes' => $routes]);
    }


    #[Route("/api/quote", name: "api_quote")]
    public function dailyQuote(): JsonResponse
    {
        $quotes = [
            "To confine our attention to terrestrial matters would be to limit the human spirit. - Stephen Hawking",
            "Somewhere, something incredible is waiting to be known. - Carl Sagan",
            "The Earth is the cradle of humanity, but mankind cannot stay in the cradle forever. - Konstantin Tsiolkovsky",
        ];

        $quote = $quotes[array_rand($quotes)];
        $data = [
            'date' => (new \DateTime())->format('Y-m-d'),
            'timestamp' => time(),
            'quote' => $quote,
        ];

        return new JsonResponse($data);
    }
}
