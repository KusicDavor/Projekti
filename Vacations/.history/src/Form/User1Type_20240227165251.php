<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class User1Type extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $roles = $this->entityManager->getRepository(Role::class)->findAll();
        $choices = [];
        foreach ($roles as $role) {
            // Assuming Role entity has properties 'id' and 'name', adjust if needed
            $choices[$role->getRoleName()] = $role->getRoleTag();
        }
        $builder
            ->add('email')
            ->add('password')
            ->add('roles', ChoiceType::class, [
                'choices' => $choices,
                'multiple' => true, // Allow selecting multiple roles
                'expanded' => true, // Display as checkboxes
            ]);
        $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPostSubmit']);
    }

    public function onPostSubmit(FormEvent $event)
    {
        $user = $event->getData();
        $form = $event->getForm();

        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $user->getPassword()
            ),
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
