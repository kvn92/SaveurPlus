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
use Symfony\Component\Security\Http\Attribute\IsCsrfTokenValid;

#[Route('/categorie', name: 'categorie.')]

class CategorieController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(Request $request, CategorieRepository $categorieRepository): Response
    {

        $categorie = $categorieRepository->findAll();
        $totalCategories = $categorieRepository->count([]);
        $activeCategories = $categorieRepository->count(['isActive' => true]);
        $inactiveCategories = $categorieRepository->count(['isActive' => false]);

        return $this->render('categorie/index.html.twig', [
        'title'=>'Categorie',
        'titles'=>'Categories',
        'totalCategories' => $totalCategories,
        'activeCategories' => $activeCategories,
        'inactiveCategories' => $inactiveCategories,
        'categories'=>$categorie,
            
        ]);
    }

    #[Route('/new', name: 'new',methods:['POST','GET'])]
    public function new(Request $request,EntityManagerInterface $entityManager): Response
    {

        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie,
        ['is_edit'=>true]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($categorie);
            $entityManager->flush();
            $this->addFlash('success','Ajouter');
            return $this->redirectToRoute('categorie.index');
        }
        return $this->render('categorie/new.html.twig', [
            "form"=>$form->createView()
        ]);

        
    }

    #[Route('/{id}/edit', name: 'edit',methods:['POST','GET'],requirements:['id'=>Requirement::DIGITS])]
    public function update(Request $request,EntityManagerInterface $entityManager, Categorie $categorie): Response
    {

        $form = $this->createForm(CategorieType::class, $categorie,['is_edit'=>false]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($categorie);
            $entityManager->flush();
            $this->addFlash('success','Modifier');
            return $this->redirectToRoute('categorie.index');
        }
        return $this->render('categorie/new.html.twig', [
            "form"=>$form->createView()
        ]);
        
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['DELETE'])]   
     public function remove(Request $request, EntityManagerInterface $entityManager,Categorie $categorie) {

        if($this->isCsrfTokenValid('delete'. $categorie->getId() ,$request->request->get('_token'))){
            $entityManager->remove($categorie);
            $entityManager->flush();
            $this->addFlash('danger',$categorie->getCategorie().' a été supprimé ');
            return $this->redirectToRoute('categorie.index');
    }

}

}