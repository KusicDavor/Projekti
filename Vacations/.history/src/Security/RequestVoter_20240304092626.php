<?php

namespace App\Security;

use App\Entity\VacationRequest;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RequestVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === 'EDIT' && $subject instanceof VacationRequest;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Check if the user has the ROLE_TEAM_LEADER role
        if ($this->security->isGranted('ROLE_TEAM_LEADER')) {
            return true;
        }

        return false;
    }
}
