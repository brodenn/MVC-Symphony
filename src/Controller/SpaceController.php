<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpaceController extends AbstractController
{
    #[Route('/space/facts', name: 'space_facts')]
    public function showSpaceFacts(): Response
    {
        $jsonPath = $this->getParameter('kernel.project_dir') . '/public/data/space-facts.json';
        $jsonData = file_get_contents($jsonPath);
        $facts = json_decode($jsonData, true);

        return $this->render('space_facts.html.twig', [
            'facts' => $facts['facts']
        ]);
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        // Define the fictional character details
        $character = [
            'name' => 'Commander Cosmo',
            'role' => 'Interstellar Navigator',
            'bio' => 'Commander Cosmo, known for navigating the treacherous asteroid fields of the Outer Rim, has dedicated their life to charting the cosmos and discovering new frontiers. With a heart as vast as space itself, Cosmo inspires countless budding astronauts to reach for the stars.',
            'image' => 'img/astronaut.jpg' // Ensure the image path is correct
        ];

        return $this->render('home.html.twig', [
            'character' => $character
        ]);
    }
    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }
}
