<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Repository\ChambreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
  #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
  public function index(ChambreRepository $chambreRepository): Response
  {
    $chambres = $chambreRepository->findAll();
    return $this->render('home/index.html.twig', [
      'chambres' => $chambres
    ]);
  }

  #[Route('/chambre/{id}', name: 'chambre', methods: ['GET', 'POST'])]
  public function chambre(Chambre $chambre): Response
  {
    return $this->render('home/chambre.html.twig', [
      'chambre' => $chambre
    ]);
  }
}
