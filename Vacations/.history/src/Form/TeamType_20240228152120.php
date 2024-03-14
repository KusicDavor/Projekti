<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Name: ',
            'attr' => ['class' => 'form-control']
        ])
            ->add('teamLeader', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control']
            ])
            ->add('projectLeader', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}