<?php

namespace App\Controller;

use App\Entity\VacationRequest;
use App\Repository\VacationRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $stats = $entityManager->getRepository(VacationRequest::class)->stats();

        $cache = new FilesystemAdapter();
        $cachedStats = $cache->get('stats', function (ItemInterface $item) {
            // Fetch the data from the database or wherever you get it from
            $stats = [
                'approved' => 10,
                'declined' => 5,
                'total' => 15,
            ];

            // Cache the data for 3600 seconds (1 hour)
            $item->expiresAfter(3600);

            return $stats;
        });

        return $this->render('index.html.twig', [
            'cachedStats' => $cachedStats,
        ]);

        
        return $this->render('index/index.html.twig', [
            'stats' => $stats,
        ]);
    }
}
