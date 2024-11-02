<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Categorie', TextType::class, [
            'label' => 'Categorie',
            'required' => true,
        ])
        ->add('isActive', ChoiceType::class, [
            'label' => 'Afficher',
            'choices' => [
                'Active' => true,
                'Désactiver' => false
            ],
            'expanded' => true,  // Affiche les choix sous forme de boutons radio
            'multiple' => false,  // Choix unique
        ])
        ->add('submit', SubmitType::class, [
            'label' => $options['is_edit'] ? 'Ajouter' : 'Modifier'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
            'is_edit'=>false
        ]);
    }
}
