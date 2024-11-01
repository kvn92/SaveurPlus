<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/categorie', name: 'categorie.')]

class CategorieController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            
        ]);
    }

    #[Route('/new', name: 'new',methods:['POST','GET'])]
    public function new(Request $request,EntityManagerInterface $entityManagerInterface): Response
    {

        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManagerInterface->persist($categorie);
            $entityManagerInterface->flush();
            $this->addFlash('success','Ajouter');
            return $this->redirectToRoute('categorie.index');
        }
        return $this->render('categorie/new.html.twig', [
            "form"=>$form
        ]);

        
    }

    #[Route('/{id}/edit', name: 'edit',methods:['POST','GET'],requirements:['id'=>Requirement::DIGITS])]
    public function update(Request $request,EntityManagerInterface $entityManagerInterface, CategorieRepository $categorie): Response
    {

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManagerInterface->persist($categorie);
            $entityManagerInterface->flush();
            $this->addFlash('success','Modifier');
            return $this->redirectToRoute('categorie.index');
        }
        return $this->render('categorie/new.html.twig', [
            "form"=>$form
        ]);
    }

}
