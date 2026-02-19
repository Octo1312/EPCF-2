<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Color;
use App\Form\CardFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CardController extends AbstractController
{
    #[Route('/cartes/creation/step1', name: 'addcard')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $card = new Card();

        $form = $this->createForm(CardFormType::class, $card);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            $card->setUser($this->getUser());
            $entityManager->persist($card);
            $entityManager->flush();
            $this->addFlash('success','Carte ajouté avec succès !');
            return $this->redirectToRoute('addcard');
        
        }
        return $this->render('card/addcard.html.twig', [
            'addcard'=>$form->createView(),
        ]);
    }
}

