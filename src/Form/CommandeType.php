<?php

namespace App\Form;

use App\Entity\Membre;
use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class CommandeType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('date_heure_depart', DateType::class, [
        'widget' => 'single_text',
        'label' => 'Date de début de la location',
        'attr' => [
          'class' => 'datepicker',
        ],
      ])
      ->add('date_heure_fin', DateType::class, [
        'widget' => 'single_text',
        'label' => 'Date de fin de la location',
        'attr' => [
          'class' => 'datepicker',
        ],
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Commande::class,
    ]);
  }



}
