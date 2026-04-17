<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use App\Repository\GenreRepository;
use App\Repository\LivreRepository;
use App\Repository\UserActivityRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('', name: 'admin_dashboard', methods: ['GET'])]
    public function dashboard(
        LivreRepository $livreRepository,
        AuteurRepository $auteurRepository,
        GenreRepository $genreRepository,
        UserRepository $userRepository,
        UserActivityRepository $activityRepository
    ): Response {
        return $this->render('admin/dashboard.html.twig', [
            'stats' => [
                'livres' => $livreRepository->count([]),
                'auteurs' => $auteurRepository->count([]),
                'genres' => $genreRepository->count([]),
                'users' => $userRepository->count([]),
                'activities' => $activityRepository->count([]),
            ],
            'recentActivities' => $activityRepository->findRecentGlobal(8),
        ]);
    }
}
