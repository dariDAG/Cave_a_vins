<?php

namespace App\Controller;

use App\Repository\VinRepository;
use App\Service\MessageGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/', name: 'home')]
    public function home(VinRepository $repo, MessageGenerator $msgGen): Response
    {
        $msg = $msgGen->getMessage('loginOk');
        $this->addFlash('notif', $msg);

        //$stock = $repo->nbrVinEnCave();
        //$stockBlanc = $repo->nbrVinEnCaveByRobe('blanc');
        //$stockRouge = $repo->nbrVinEnCaveByRobe('rouge');
        //$stockRose = $repo->nbrVinEnCaveByRobe('rose');
        $stocks = $repo->stock();
        return $this->render('home/home.html.twig', [
            'stocks' => $stocks,
            //'stock_blanc' => $stockBlanc,
            //'stock_rouge' => $stockRouge,
            //'stock_rose' => $stockRose,

        ]);
    }
}
