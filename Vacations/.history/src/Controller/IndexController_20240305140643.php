<?php

namespace App\Controller;

use App\Entity\VacationRequest;
use App\Repository\VacationRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $stats = $entityManager->getRepository(VacationRequest::class)->stats();
        $approvedCount = $vacationRequestRepository->countApprovedRequests();
        $declinedCount = $vacationRequestRepository->countDeclinedRequests();
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController', [
                'stats' => $stats
            ]
        ]);
    }
}