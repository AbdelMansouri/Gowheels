<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                "choices"   => [
                    "Admin" => "ROLE_ADMIN",
                    "Utilisateur" => "ROLE_USER"
                ],
                "multiple" => true,
                "expanded" => true,
                "label" => "Droit d'accès"
            ])
            // ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('civilite', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'M',
                    'Femme' => 'F',
                ],
            ]);
            // ->add('date_enregistrement');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
