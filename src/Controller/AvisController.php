<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Repository\AvisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/avis')]
class AvisController extends AbstractController
{
  #[Route('/', name: 'app_avis_index', methods: ['GET', 'POST'])]
  public function index(AvisRepository $avisRepository, Request $request): Response
  {
    $avis_ = $avisRepository->findAll();
    $avis = new Avis;
    $form = $this->createForm(AvisType::class, $avis);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $user = $this->getUser();
      $avis->setUser($user);
      $avis->setCreatedAt(new \DateTimeImmutable('now'));

      $avisRepository->add($avis, true);

      $this->addFlash('success', 'Votre avis a bien été déposé');

      return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('avis/index.html.twig', [
      'form' => $form->createView(),
      'avis' => $avis,
      'avis_' => $avis_
    ]);
  }

  #[Route('/{id}', name: 'app_avis_delete', methods: ['POST'])]
  public function delete(Request $request, Avis $avis, AvisRepository $avisRepository): Response
  {
    if ($this->isCsrfTokenValid('delete' . $avis->getId(), $request->request->get('_token'))) {
      $avisRepository->remove($avis, true);
    }

    return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
  }
}
