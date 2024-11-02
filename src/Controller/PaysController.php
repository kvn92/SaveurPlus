<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Form\PaysType;
use App\Repository\PaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/pays', name: 'pays.')]

class PaysController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(PaysRepository $paysRepository): Response
    {
        
        $totalPays = $paysRepository->count();
        $activePays = $paysRepository->count(['isActive'=>true]);
        $inactivePays = $paysRepository->count(['isActive'=>false]);
        $pays = $paysRepository->findAll();
        return $this->render('pays/index.html.twig', [
            'title'=>'Pays',
            'totalPays'=>$totalPays,
            'activePays'=>$activePays,
            'inactivePays'=>$inactivePays,
            'pays' => $pays
        ]);
    }

    #[Route('/new', name:'new',methods:['POST','GET'])]
    public function new(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $pays = new Pays;
        $form = $this->createForm(PaysType::class, $pays,
    ['is_edit'=>true]);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManagerInterface->persist($pays);
            $entityManagerInterface->flush();
            $this->addFlash('success','Ajouter');
            return $this->redirectToRoute('pays.index');
        }

        return $this->render('pays/new.html.twig', ['title'=>'Pays',
            'pays' => $pays,'form'=>$form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'edit',methods:['POST','GET'],requirements:['id'=>Requirement::DIGITS])]
    public function update(Request $request,EntityManagerInterface $entityManagerInterface,Pays $pays): Response
    {
        $form = $this->createForm(PaysType::class, $pays);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManagerInterface->persist($pays);
            $entityManagerInterface->flush();
            $this->addFlash('success','ajoute');
            return $this->redirectToRoute('pays.index');
        }
        return $this->render('pays/update.html.twig', ['title'=>'Pays',
            'pays' => $pays,'form'=>$form
        ]);
    }

    #[Route('/{id}/delete',name:"delete",methods:['DELETE'])]

    public function remove(Request $request,EntityManagerInterface $entityManagerInterface,Pays $pays,$id){


        if($this->isCsrfTokenValid('delete'.$pays->getId(), $request->request->get('_token')))
        $entityManagerInterface->remove($pays);
        $entityManagerInterface->flush();
        return $this->redirectToRoute('pays.index');

    }
}
