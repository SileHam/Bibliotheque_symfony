<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use App\Repository\GenreRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(AuteurRepository $auteurRepository, LivreRepository $livreRepository, GenreRepository $genreRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'auteurs' => $auteurRepository->findAll(),
            'livres' => $livreRepository->findFeatured(),
            'genres' => $genreRepository->findAll(),
        ]);
    }
}
