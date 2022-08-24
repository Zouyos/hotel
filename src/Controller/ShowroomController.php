<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CategorieRepository;
use App\Repository\ChambreRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowroomController extends AbstractController
{
  #[Route('/showroom', name: 'app_showroom', methods: ['GET', 'POST'])]
  public function index(ChambreRepository $chambreRepository): Response
  {
    $chambres = $chambreRepository->findAll();
    return $this->render('showroom/index.html.twig', [
      'chambres' => $chambres
    ]);
  }

  #[Route('/showroom/classique', name: 'app_showroom_classique', methods: ['GET', 'POST'])]
  public function indexClassique(ChambreRepository $chambreRepository, CategorieRepository $categorieRepository): Response
  {
    $confort = $categorieRepository->find(1);
    $chambres = $chambreRepository->findBy([
      "categorie" => $confort
    ]);

    // dd($chambres);
    return $this->render('showroom/classique.html.twig', [
      'chambres' => $chambres
    ]);
  }

  #[Route('/showroom/confort', name: 'app_showroom_confort', methods: ['GET', 'POST'])]
  public function indexConfort(ChambreRepository $chambreRepository, CategorieRepository $categorieRepository): Response
  {
    
    $confort = $categorieRepository->find(2);
    $chambres = $chambreRepository->findBy([
      "categorie" => $confort
    ]);

    return $this->render('showroom/confort.html.twig', [
      'chambres' => $chambres
    ]);
  }

  #[Route('/showroom/suite', name: 'app_showroom_suite', methods: ['GET', 'POST'])]
  public function indexSuite(ChambreRepository $chambreRepository, CategorieRepository $categorieRepository): Response
  {
    $confort = $categorieRepository->find(3);
    $chambres = $chambreRepository->findBy([
      "categorie" => $confort
    ]);
    return $this->render('showroom/suite.html.twig', [
      'chambres' => $chambres
    ]);
  }

  #[Route('/chambre/{id}', name: 'chambre', methods: ['GET', 'POST'])]
  public function chambre(Chambre $chambre, Request $request, CommandeRepository $commandeRepository): Response
  {
    $commande = new Commande;
    $form = $this->createForm(CommandeType::class, $commande);
    $form->handleRequest($request); // aucune idée de ce que ça veut dire, se renseigner

    if ($form->isSubmitted() && $form->isValid()) {

      $user = $this->getUser();
      $commande->setUser($user);
      $commande->setChambre($chambre);

      $start = $commande->getStartAt();
      $end = $commande->getEndAt();

      $diff = $start->diff($end);
      $days = $diff->days;

      $startHour = $start->format('H');
      $endHour = $end->format('H');

      if ($startHour < $endHour) {
        $days = $days + 1;
      }

      $result = round($days * $chambre->getPrix(), 2);
      $commande->setPrix($result);

      $commande->setCreatedAt(new \DateTimeImmutable('now'));
      $commandeRepository->add($commande, true);

      $this->addFlash('success', 'Votre réservation a bien été prise en compte');

      return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('showroom/chambre.html.twig', [
      'chambre' => $chambre,
      'form' => $form->createView()
    ]);
  }
}
