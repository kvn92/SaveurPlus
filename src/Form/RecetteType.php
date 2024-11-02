<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Recette;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomRecette')
            ->add('descriptionRecette')
            ->add('thumbnailRecette')
            ->add('isActive')
            ->add('createAt', null, [
                'widget' => 'single_text'
            ])
            ->add('Duree')
            ->add('users', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
