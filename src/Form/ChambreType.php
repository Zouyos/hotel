<?php

namespace App\Form;

use App\Entity\Chambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ChambreType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('titre', TextType::class, [
        'required' => false,
      ])
      ->add('descriptionCourte', TextType::class, [
        'required' => false,
      ])
      ->add('descriptionLongue', TextType::class, [
        'required' => false,
      ])
      ->add('photo', UrlType::class, [
        'required' => false,
      ])
      ->add('prix', MoneyType::class, [
        'required' => false,
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Chambre::class,
    ]);
  }
}
