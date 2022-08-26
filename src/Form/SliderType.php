<?php

namespace App\Form;

use App\Entity\Slider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SliderType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('ordre')
      ->add('photo', UrlType::class, [
        'required' => false,
      ])
      ->add('alt', TextType::class, [
        'required' => false,
      ])
      ->add('title', TextType::class, [
        'required' => false,
      ])
      ->add('caption', TextType::class, [
        'required' => false,
      ])
      ->add('description', TextType::class, [
        'required' => false,
      ])
      ->add('status', ChoiceType::class, [
        'required' => false,
        'choices' => [
          'Activer' => 'Actif'
        ],
        "expanded" => true
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Slider::class,
    ]);
  }
}
