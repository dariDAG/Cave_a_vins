<?php

namespace App\Controller;

use App\Repository\VinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VinController extends AbstractController
{
    #[Route('/vin/list', name: 'vin.list')]
    public function list(VinRepository $vinRepository): Response
    {
        $vins = $vinRepository->findAll();
        //dump($vins);
        return $this->render('vin/list.html.twig', [
            'vins' => $vins,
        ]);
    }

}

