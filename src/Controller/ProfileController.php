<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

  #[Route('/password/edit', name: 'app_profile_password_edit', methods: ['GET', 'POST'])]
  public function editPassword(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
  {
    $user = $this->getUser();

   // dd($user);
    $form = $this->createForm(RegistrationFormType::class, $user, [
      'updatePassword' => true,
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) 
    {

      $currentPassword = $form->get('currentPassword')->getData();
      $newPassword = $form->get('newPassword')->getData();
      $confirmPassword = $form->get('confirmPassword')->getData();

      $access = true;

      if (!$currentPassword) 
      {
        $access = false;
        $form->get('currentPassword')->addError(new FormError('Saisir votre mot de passe actuel.'));
      } 
      else
      {
        if (!$passwordHasher->isPasswordValid($user, $currentPassword)) // boolean
        {
          $access = false;
          $form->get('currentPassword')->addError(new FormError('Le mot de passe est incorrect.'));
        } 
        else
        {
          if ($newPassword != $confirmPassword) 
          {
            $access = false;
            $form->get('newPassword')->addError(new FormError('Les mots de passe ne corresspondent pas.'));
            $form->get('confirmPassword')->addError(new FormError('Les mots de passe ne corresspondent pas.'));
          } 
          else
          {
            if (!$newPassword) // si confirm est vide ça va empêcher d'envoyer un mdp vide en bdd
            {
              $access = false;
              $form->get('newPassword')->addError(new FormError('Saisir un nouveau mot de passe.'));
            } 
            else
            {
              if ($newPassword == $currentPassword) 
              {
                $access = false;
                $form->get('newPassword')->addError(new FormError('Saisir un mot de passe différent de votre mot de passe actuel.'));
              }
            }
          }
        }
      }

      if ($access) 
      {
        $user->setPassword(
          $passwordHasher->hashPassword($user, $newPassword)
        );

        $userRepository->add($user, true);
        $this->addFlash('success', 'Votre mot de passe a bien été modifié');

        return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
      }

    }

    return $this->render('profile/password/edit.html.twig', [
      'form' => $form->createView()
    ]);
  }

  #[Route('/commande/edit/{id}', name: 'app_profile_commande_edit', methods: ['GET', 'POST'])]
  public function editCommande(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
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
      $this->addFlash('success', 'Votre commande a bien été mise à jour');

      return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('profile/commande/edit.html.twig', [
      'commande' => $commande,
      'form' => $form,
    ]);
  }

  #[Route('/commande/{id}', name: 'app_profile_commande_delete', methods: ['POST'])]
  public function delete(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
  {
    if ($this->isCsrfTokenValid('delete' . $commande->getId(), $request->request->get('_token'))) {
      $commandeRepository->remove($commande, true);
      $this->addFlash('success', 'La réservation a bien été supprimée');
    }

    return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
  }
}
