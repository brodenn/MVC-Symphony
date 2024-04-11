<?php

namespace App\Controller;

use App\Entity\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionController extends AbstractController
{
    #[Route("/session", name: "session_index")]
    public function index(SessionInterface $session): Response
    {
        $sessionContent = [];
        foreach ($session->all() as $key => $value) {
            if ($value instanceof DeckOfCards) {
                $cards = $value->getCards();
                $cardDescriptions = [];
                foreach ($cards as $card) {
                    $cardDescriptions[] = (string)$card;
                }
                $sessionContent[$key] = $cardDescriptions;
            } else {
                $sessionContent[$key] = $value;
            }
        }

        return $this->render('session/index.html.twig', [
            'sessionContent' => $sessionContent,
        ]);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function delete(SessionInterface $session): Response
    {
        $session->clear();
        $this->addFlash('success', 'Session cleared successfully.');
        return $this->redirectToRoute('session_index');
    }
}
