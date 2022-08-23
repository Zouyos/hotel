<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Chambre;
use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CommandeType extends AbstractType
{

  public function heures()
  {
    $heures = [];

    for ($i = 8; $i < 20; $i++) {
      $heures[] = $i;
    }
    return $heures;
  }

  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('startAt', DateTimeType::class, [
        "required" => false,
        "date_widget" => "single_text",
        "hours" => $this->heures(),
        "minutes" => [0, 15, 30, 45],
        "placeholder" => false,
        "label" => "Début de réservation"
      ])
      ->add('endAt', DateTimeType::class, [
        "required" => false,
        "date_widget" => "single_text",
        "hours" => $this->heures(),
        "minutes" => [0, 15, 30, 45],
        "placeholder" => false,
        "label" => "Fin de réservation"
      ]);

    if ($options['relations']) {
      $builder
        ->add('user', EntityType::class, [
          "class" => User::class,
          "choice_label" => "email",
          "required" => false,
          "label" => "Client"
        ])
        ->add('chambre', EntityType::class, [
          "class" => Chambre::class,
          "choice_label" => "titre",
          "required" => false,
        ]);
    }
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Commande::class,
      'relations' => false,
    ]);
  }
}
