<?php

namespace App\Event;

use App\Entity\VacationRequest;
use Symfony\Contracts\EventDispatcher\Event;

class VacationRequestApprovedEvent extends Event
{
    public const NAME = 'vacation_request.approved';

    private $requestId;

    public function __construct(VacationRequest $$vacatRequest)
    {
        $this->requestId = $requestId;
    }

    public function getRequestId(): int
    {
        return $this->requestId;
    }
}
