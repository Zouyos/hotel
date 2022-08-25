<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
  #[Route('/', name: 'app_home', methods: ['GET'])]
  public function index(): Response
  {
    return $this->render('home/index.html.twig');
  }

  #[Route('/restaurant', name: 'app_resto', methods: ['GET'])]
  public function resto(): Response
  {
    return $this->render('home/resto.html.twig');
  }

  #[Route('/spa', name: 'app_spa', methods: ['GET'])]
  public function spa(): Response
  {
    return $this->render('home/spa.html.twig');
  }

  #[Route('/a-propos', name: 'app_a_propos', methods: ['GET'])]
  public function aPropos(): Response
  {
    return $this->render('home/a_propos.html.twig');
  }

  #[Route('/acces', name: 'app_acces', methods: ['GET'])]
  public function acces(): Response
  {
    return $this->render('home/acces.html.twig');
  }

  #[Route('/contact', name: 'app_contact', methods: ['GET'])]
  public function contact(): Response
  {
    return $this->render('home/contact.html.twig');
  }
}
