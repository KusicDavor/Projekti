<?php

namespace App\Form;

use App\Entity\VacationRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Carbon\Carbon;

class VacationRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];

        $builder
            ->add('startDate', DateType::class, [
                'label' => 'Starting date',
                'attr' => ['class' => 'form-control'],
                'data' => new \DateTime(),
                'constraints' => [
                    new Callback([$this, 'checkSelectedDateNotWeekend']),
                    new Callback([$this, 'checkStartingDate']),
                ],
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Ending date',
                'attr' => ['class' => 'form-control'],
                'data' => new \DateTime(),
                'constraints' => [
                    new Callback([$this, 'checkSelectedDateNotWeekend']),
                    new Callback([$this, 'checkEndingDate']),
                ],
            ])
            ->add('note', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ]);

        // provjera duljine trajanja vacationa
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($user) {
            $formData = $event->getData();
            $startDate = $formData['startDate'];
            $endDate = $formData['endDate'];
            $startDate = \DateTime::createFromFormat('Y-m-d', $startDate);
            $endDate = \DateTime::createFromFormat('Y-m-d', $endDate);

            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);

            $interval = $endDate->diff($startDate);
            $daysDiff = $interval->days;

            if ($daysDiff > $user->getVacationDays()) {
                $form = $event->getForm();
                $form->addError(new FormError('You don\'t have enough days for a vacation of selected range.'));
            }

            $maxNumberOfVacationDays = 20;
            if ($daysDiff > $maxNumberOfVacationDays) {
                $form = $event->getForm();
                $form->addError(new FormError('Maximum number of vacation days is ' . $maxNumberOfVacationDays));
            }
        });
    }

    public function checkSelectedDateNotWeekend($date, ExecutionContextInterface $context)
    {
        $dateTime = new \DateTime($date->format('Y-m-d'));

        // N je dan u tjednu
        if ($dateTime->format('N') >= 6) {
            $context->buildViolation('Selected date cannot be on a weekend.')
                ->addViolation();
        }
    }

    public function checkStartingDate($date, ExecutionContextInterface $context)
    {
        $todayPlusOneDay = (new \DateTime());
        if ($date < $todayPlusOneDay) {
            $context->buildViolation('Starting date cannot be before today\'s date plus one day at least.')
                ->atPath('startDate')
                ->addViolation();
        }
    }

    public function checkEndingDate($endDate, ExecutionContextInterface $context)
    {
        $startDate = $context->getRoot()->get('startDate')->getData();
        if ($endDate < $startDate) {
            $context->buildViolation('Ending date cannot be before start date.')
                ->atPath('endDate')
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
