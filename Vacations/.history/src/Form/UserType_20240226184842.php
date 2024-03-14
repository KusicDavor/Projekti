<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\Team;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('job')
            ->add('vacationDays')
            ->add('name')
            ->add('team', EntityType::class, [
                'class' => Team::class,
'choice_label' => 'teamName',
            ])
            ->add('role', EntityType::class, [
                'class' => Role::class,
'choice_label' => 'roleName',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}