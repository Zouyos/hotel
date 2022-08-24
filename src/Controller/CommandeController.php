<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/commande')]
class CommandeController extends AbstractController
{
  #[Route('/', name: 'app_commande_index', methods: ['GET'])]
  public function index(CommandeRepository $commandeRepository): Response
  {
    return $this->render('commande/index.html.twig', [
      'commandes' => $commandeRepository->findAll(),
    ]);
  }

  #[Route('/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
  public function new(Request $request, CommandeRepository $commandeRepository): Response
  {
    $commande = new Commande();
    $form = $this->createForm(CommandeType::class, $commande, [
      'relations' => true,
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $start = $commande->getStartAt();
      $end = $commande->getEndAt();

      $diff = $start->diff($end);
      $days = $diff->days;

      // ======
      $startHour = $start->format('H');
      $endHour = $end->format('H');

      if ($startHour < $endHour) {
        $days = $days + 1;
      }
      // ======

      $resultat = round($days * $commande->getChambre()->getPrix(), 2);

      $commande->setPrix($resultat);

      $commande->setCreatedAt(new \DateTimeImmutable('now'));
      $commandeRepository->add($commande, true);

      return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('commande/new.html.twig', [
      'commande' => $commande,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_commande_show', methods: ['GET'])]
  public function show(Commande $commande): Response
  {
    return $this->render('commande/show.html.twig', [
      'commande' => $commande,
    ]);
  }

  #[Route('/edit/{id}', name: 'app_commande_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
  {
    $form = $this->createForm(CommandeType::class, $commande);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $start = $commande->getStartAt();
      $end = $commande->getEndAt();

      $diff = $start->diff($end);
      $days = $diff->days;

      $startHour = $start->format('H');
      $endHour = $end->format('H');

      if ($startHour < $endHour) {
        $days = $days + 1;
      }

      $resultat = round($days * $commande->getChambre()->getPrix(), 2);

      $commande->setPrix($resultat);

      $commandeRepository->add($commande, true);

      return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('commande/edit.html.twig', [
      'commande' => $commande,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_commande_delete', methods: ['POST'])]
  public function delete(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
  {
    if ($this->isCsrfTokenValid('delete' . $commande->getId(), $request->request->get('_token'))) {
      $commandeRepository->remove($commande, true);
    }

    return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
  }
}
