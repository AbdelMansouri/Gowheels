<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class VehiculeType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('titre')
      ->add('marque')
      ->add('modele')
      ->add('description')
      ->add('photo', FileType::class, [
        'mapped' => false,
        'required' => false,
        'constraints' => [
          new File([
            "maxSize" => '5120K',
            "mimeTypes" => [
              'image/jpeg',
              'image/png',
              'image/webp',
            ],
            "mimeTypesMessage" => "Insérer un fichier valide",
          ])
        ]
      ])
      ->add('prix_journalier');
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Vehicule::class,
    ]);
  }
}
