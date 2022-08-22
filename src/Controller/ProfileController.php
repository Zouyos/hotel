<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile')]
class ProfileController extends AbstractController
{
  #[Route('/', name: 'app_profile')]
  public function index(): Response
  {
    return $this->render('profile/index.html.twig', [
      'controller_name' => 'ProfileController',
    ]);
  }

  #[Route('/edit', name: 'app_profile_edit')]
  public function edit(Request $request, UserRepository $userRepository): Response
  {
    $user = $this->getUser();
    $form = $this->createForm(RegistrationFormType::class, $user, [
      'nom' => true,
      'prenom' => true,
      'email' => true,
      // 'password' => true,
      'pseudo' => true,
      'sexe' => true,
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $userRepository->add($user, true);
      $this->addFlash('success', 'Votre profil a bien été mis à jour');

      return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('profile/edit.html.twig', [
      'user' => $user,
      'form' => $form
    ]);
  }
}
