<?php

namespace App\Form;

use App\Entity\VacationRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class VacationRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];

        $builder
            ->add('startDate', DateType::class, [
                'constraints' => [
                    new Callback([$this, 'checkSelectedDateNotWeekend']),
                ],
                'label' => 'Starting date',
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Ending date',
                'constraints' => [
                    new Callback([$this, 'checkSelectedDateNotWeekend']),
                ],
            ])
            ->add('note');
    }

    public function checkSelectedDateNotWeekend($date, ExecutionContextInterface $context)
    {
        $dateTime = new \DateTime($date->format('Y-m-d'));

        // N je dan u tjednu
        if ($dateTime->format('N') >= 6) { // 6 is Saturday, 7 is Sunday
            $context->buildViolation('Selected date cannot be on a weekend.')
                ->addViolation();
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VacationRequest::class,
            'user' => null,
        ]);
    }
}
