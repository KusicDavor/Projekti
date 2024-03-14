<?php

namespace App\EventListener;

use App\Entity\VacationRequest;
use App\Event\VacationRequestApprovedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class VacationRequestApprovedSubscriber implements EventSubscriberInterface
{
    private $vacationRequest;
    public function __construct(VacationRequest $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'updateVacationDays',
        ];
    }

    public function updateVacationDays(ExceptionEvent $event): void
    {
        $user = 1;
    }
}