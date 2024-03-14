<?php

namespace App\Events;

use App\Entity\User;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class VacationRequestApprovedListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            VacationRequestApprovedEvent::class => 'onVacationRequestApproved',
        ];
    }

    public function onVacationRequestApproved(VacationRequestApprovedEvent $event, EntityManager $entityManager)
    {
        $vacationRequest = $event->getVacationRequest();
        $startDate = Carbon::parse($vacationRequest->getStartDate());
        $endDate = Carbon::parse($vacationRequest->getEndDate());

        $daysDiff = $startDate->diffInWeekdays($endDate);
        $newVacationDays = $vacationRequest->getUser()->getVacationDays() - $daysDiff;
        $vacationRequest->getUser()->setVacationDays($newVacationDays);

        $entityManager->getRepository(User::class)->save($vacationRequest);
        // Perform actions when both the team leader and project leader approve the request
        // For example, update the request status in the database, send notifications, etc.
    }
}
