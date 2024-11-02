<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\User;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;


#[Route('commentaire', name: 'commentaire.')]
class CommentaireController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(Request $request,CommentaireRepository $commentaireRepository): Response
    {

        $commentaires = $commentaireRepository->findAll();

        

        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    #[Route('/new',name:'new',methods:['POST','GET'])]

public function new(Request $request,EntityManagerInterface $entityManager, Security $security): Response{


        $user = $security->getUser();
        $commentaire = new Commentaire();
        $commentaire->setCreateAt( new \DateTimeImmutable());
        $commentaire->setUser($user);

        $form = $this->createForm(CommentaireType::class, $commentaire,
        ['is_edit'=>true]);


        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {     
           
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('commentaire.index');
            
        }

        return $this->render("commentaire/new.html.twig",[
            'form'=>$form
        ]);
    }

    
}
