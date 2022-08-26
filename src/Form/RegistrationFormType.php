<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    if ($options['email']) {
      $builder
        ->add('email', TextType::class, [
          'required' => false,
        ]);
    }

    if ($options['agree']) {
      $builder
        ->add('agreeTerms', CheckboxType::class, [
          'required' => false,
          'mapped' => false,
          'constraints' => [
            new IsTrue([
              'message' => 'You should agree to our terms.',
            ]),
          ],
        ]);
    }

    if ($options['password']) {
      $builder
        ->add('plainPassword', PasswordType::class, [
          // instead of being set onto the object directly,
          // this is read and encoded in the controller
          'mapped' => false,
          'required' => false,
          'attr' => ['autocomplete' => 'new-password'],
          'constraints' => [
            new NotBlank([
              'message' => 'Please enter a password',
            ]),
            new Length([
              'min' => 6,
              'minMessage' => 'Your password should be at least {{ limit }} characters',
              // max length allowed by Symfony for security reasons
              'max' => 4096,
            ]),
          ],
        ]);
    }

    if ($options['pseudo']) {
      $builder
        ->add('pseudo', TextType::class, [
          'required' => false,
        ]);
    }

    if ($options['nom']) {
      $builder
        ->add('nom', TextType::class, [
          'required' => false,
        ]);
    }

    if ($options['prenom']) {
      $builder
        ->add('prenom', TextType::class, [
          'required' => false,
        ]);
    }

    if ($options['roles']) {
      $builder
        ->add('roles', ChoiceType::class, [
          'required' => false,
          'choices' => [
            'Admin' => 'ROLE_ADMIN'
          ],
          "multiple" => true,
          "expanded" => true
        ]);
    }

    if ($options['sexe']) {
      $builder
        ->add('sexe', ChoiceType::class, [
          'required' => false,
          'placeholder' => false,
          'label' => 'Civilité',
          'choices' => [
            'Madame' => 'Mme.',
            'Monsieur' => 'M.'
          ],
          "multiple" => false,
          "expanded" => true
        ]);
    }

    if ($options['updatePassword']) {
      $builder
        ->add('currentPassword', PasswordType::class, [
          'mapped' => false,
          'required' => false,
          'attr' => ['autocomplete' => 'new-password'],
          'constraints' => [
            new Length([
              'min' => 6,
              'minMessage' => 'Your password should be at least {{ limit }} characters',
              'max' => 4096,
            ]),
          ],
        ])
        ->add('newPassword', PasswordType::class, [
          'mapped' => false,
          'required' => false,
          'attr' => ['autocomplete' => 'new-password'],
          'constraints' => [
            new Length([
              'min' => 6,
              'minMessage' => 'Your password should be at least {{ limit }} characters',
              'max' => 4096,
            ]),
          ],
        ])
        ->add('confirmPassword', PasswordType::class, [
          'mapped' => false,
          'required' => false,
          'attr' => ['autocomplete' => 'new-password'],
          'constraints' => [
            new Length([
              'min' => 6,
              'minMessage' => 'Your password should be at least {{ limit }} characters',
              'max' => 4096,
            ]),
          ],
        ]);
    }
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => User::class,
      'email' => false,
      'agree' => false,
      'password' => false,
      'pseudo' => false,
      'nom' => false,
      'prenom' => false,
      'roles' => false,
      'sexe' => false,
      'updatePassword' => false,
    ]);
  }
}
