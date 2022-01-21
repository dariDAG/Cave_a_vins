<?php

namespace App\Controller;

use App\Entity\Vin;
use App\Repository\VinRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class VinController extends AbstractController
{
    //#[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/vin/list', name: 'vin.list')]
    public function list(VinRepository $vinRepository): Response
    {
        $vins = $vinRepository->findAll();
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

}


