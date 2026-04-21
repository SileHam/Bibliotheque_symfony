<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Form\SearchLivreType;
use App\Repository\LivreRepository;
use App\Service\ActivityLogger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/livre')]
class LivreController extends AbstractController
{
    #[Route('/', name: 'livre_index')]
    public function index(LivreRepository $livreRepository, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $form = $this->createForm(SearchLivreType::class);
        $form->handleRequest($request);

        $searchTerm = trim((string) $form->get('titre')->getData());
        $livres = $livreRepository->findPaginatedCatalog($page, $searchTerm);
        $totalLivres = $livreRepository->countCatalog($searchTerm);

        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
            'search' => $form->createView(),
            'totalLivres' => $totalLivres,
            'searchTerm' => $searchTerm,
            'page' => $page,
            'perPage' => LivreRepository::PER_PAGE,
        ]);
    }

    #[Route('/new', name: 'livre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ActivityLogger $activityLogger): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livre);
            $entityManager->flush();
            $activityLogger->log($this->getUser(), 'book_create', sprintf('Ajout du livre "%s"', $livre->getTitre()));
            $this->addFlash('Success', 'Le livre a été ajouté avec succès.');

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}/edit', name: 'livre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livre $livre, EntityManagerInterface $entityManager, ActivityLogger $activityLogger): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $activityLogger->log($this->getUser(), 'book_update', sprintf('Modification du livre "%s"', $livre->getTitre()));
            $this->addFlash('Success', 'Le livre a été mis à jour avec succès.');

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'livre_delete', methods: ['POST'])]
    public function delete(Request $request, Livre $livre, EntityManagerInterface $entityManager, ActivityLogger $activityLogger): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $bookTitle = $livre->getTitre();
            $entityManager->remove($livre);
            $entityManager->flush();
            $activityLogger->log($this->getUser(), 'book_delete', sprintf('Suppression du livre "%s"', $bookTitle));
            $this->addFlash('Warning', 'Le livre a bien été supprimé.');
        }

        return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
    }
}
