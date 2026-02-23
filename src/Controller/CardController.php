<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Color;
use App\Entity\Type;
use App\Form\AddStepFiveType;
use App\Form\AddStepFourType;
use App\Form\AddStepOneType;
use App\Form\AddStepThreeType;
use App\Form\AddStepTwoType;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\If_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CardController extends AbstractController
{
    #[Route('/cartes/creation', name: 'addcard')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->render('card/addcard.html.twig', [
        ]);
    }

    #[Route('/cartes/creation/step1', name: 'stepone')]
    public function stepOne(Request $request, EntityManagerInterface $entityManager): Response
    {
        $card = new Card();

        $form = $this->createForm(AddStepOneType::class, $card);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            
            $card->setUser($this->getUser());
            $entityManager->persist($card);
            $entityManager->flush();
            
            $this->addFlash('success','Étape validé avec succès !');
            $id = $card->getId();
            return $this->redirectToRoute('steptwo', ['id' => $id]);
        
        }
        return $this->render('card/stepone.html.twig', [
            'stepone'=>$form->createView(),
        ]);
    }

    #[Route('/cartes/creation/step2/{id}', name: 'steptwo')]
    public function stepTwo(Card $card,Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(AddStepTwoType::class, $card);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
           
            $card->setUser($this->getUser());
            $entityManager->persist($card);
            $entityManager->flush();
            $id = $card->getId();
            $this->addFlash('success','Étape validé avec succès !');
            if ($card->getType()->getLabel() == 'Créature' ){
                return $this->redirectToRoute('stepthree', ['id' => $id]);
            } else {
                return $this->redirectToRoute('stepfour', ['id' => $id]);
            }
        }
        return $this->render('card/steptwo.html.twig', [
            'steptwo'=>$form->createView(),
        ]);
    }

    #[Route('/cartes/creation/step3/{id}', name: 'stepthree')]
    public function stepThree(Card $card,Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(AddStepThreeType::class, $card);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            
            $card->setUser($this->getUser());
            $entityManager->persist($card);
            $entityManager->flush();
            $id = $card->getId();
            $this->addFlash('success','Étape validé avec succès !');
            return $this->redirectToRoute('stepfour', ['id' => $id]);
        
        }
        return $this->render('card/stepthree.html.twig', [
            'stepthree'=>$form->createView(),
        ]);
    }

    #[Route('/cartes/creation/step4/{id}', name: 'stepfour')]
    public function stepFour(Card $card,Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(AddStepFourType::class, $card);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            
            $card->setUser($this->getUser());
            $entityManager->persist($card);
            $entityManager->flush();
            $id = $card->getId();
            $this->addFlash('success','Étape validé avec succès !');
            return $this->redirectToRoute('stepfive', ['id' => $id]);
        
        }
        return $this->render('card/stepfour.html.twig', [
            'stepfour'=>$form->createView(),
        ]);
    }

    #[Route('/cartes/creation/step5/{id}', name: 'stepfive')]
    public function stepFive(Card $card,Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(AddStepFiveType::class, $card);

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            
            $card->setUser($this->getUser());
            $entityManager->persist($card);
            $entityManager->flush();
            
            $this->addFlash('success','Étape validé avec succès !');
            return $this->redirectToRoute('home');
        
        }
        return $this->render('card/stepfive.html.twig', [
            'stepfive'=>$form->createView(),
        ]);
    }
}

