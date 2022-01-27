<?php

namespace App\Controller;

use App\Entity\Vin;
use App\Form\VinType;
use App\Repository\VinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class VinController extends AbstractController
{
    //#[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/vin/list/{robe}', name: 'vin.list')]
    public function list(VinRepository $vinRepository, Request $req): Response
    {
        $critere = $req->get('robe');
        if($critere !== 'all'){
            $vins = $vinRepository->findBy(['robe' => $critere],['qtt_stock' => 'ASC']);
        } else {
            $vins = $vinRepository->findAll();
        }
        
    
        //dump($vins);
        return $this->render('vin/list.html.twig', [
            'vins' => $vins,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/vin/show/{id}', name: 'vin.show')]
    public function show(Vin $vin): Response
    {
        dump($vin);
        return $this->render('vin/show.html.twig', [
            'vin' => $vin,
        ]);
    }

    #[Route('/vin/new', name: 'vin.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vin = new Vin();
        $form = $this->createForm(VinType::class, $vin);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($vin);
            $entityManager->flush();

            return $this->redirectToRoute( 'vin.list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vin/formNew.html.twig', [
            
            'formNew' => $form,
            
        ]);
    }

}




