<?php

namespace App\Controller;

use App\Entity\VacationRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\ItemInterface;

class IndexController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {

        $cache = new FilesystemAdapter();
        $item = $this->cache->getItem($key);
        
        $cachedStats = $cache->get('stats', function (ItemInterface $item) {
            $stats = $this->entityManager->getRepository(VacationRequest::class)->getStats();
            $item->expiresAfter(60);
            return $stats;
        });

        // $cache->clear();
        // $cachedStats = $this->entityManager->getRepository(VacationRequest::class)->getStats();
        return $this->render('index/index.html.twig', [
            'cachedStats' => $cachedStats,
        ]);
    }
}
