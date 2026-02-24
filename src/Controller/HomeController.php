<?php

namespace App\Controller;

use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CardRepository $cardRepository): Response
    {

        $card = $cardRepository->findThree();
        return $this->render('home/home.html.twig', [
            "cards" => $card,
        ]);
    }

    #[Route('/museum', name: 'museum')]
    public function galerie(CardRepository $cardRepository): Response
    {   
        $card = $cardRepository->findAll();
        return $this->render('home/museum.html.twig', [
            "cards" => $card,
        ]);
    }
}
