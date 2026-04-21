<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Entity\Livre;
use App\Entity\User;
use App\Service\ActivityLogger;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier')]
class CartController extends AbstractController
{
    #[Route('/', name: 'cart_index', methods: ['GET'])]
    public function index(CartService $cartService): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getCartSummary($user),
        ]);
    }

    #[Route('/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function add(
        Request $request,
        Livre $livre,
        CartService $cartService,
        ActivityLogger $activityLogger,
    ): RedirectResponse {
        if (!$this->isCsrfTokenValid('cart_add_'.$livre->getId(), (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        /** @var User $user */
        $user = $this->getUser();
        $quantity = $request->request->getInt('quantity', 1);

        try {
            $cartService->addBook($user, $livre, $quantity);
            $activityLogger->log($user, 'cart_add', sprintf('Ajout de "%s" au panier', $livre->getTitre()));
            $this->addFlash('Success', sprintf('"%s" a été ajouté au panier.', $livre->getTitre()));
        } catch (\DomainException $exception) {
            $this->addFlash('Warning', $exception->getMessage());
        }

        return $this->redirect($request->headers->get('referer') ?: $this->generateUrl('cart_index'));
    }

    #[Route('/update/{id}', name: 'cart_update', methods: ['POST'])]
    public function update(
        Request $request,
        CartItem $cartItem,
        CartService $cartService,
        ActivityLogger $activityLogger,
    ): RedirectResponse {
        $this->denyIfNotOwnedByCurrentUser($cartItem);

        if (!$this->isCsrfTokenValid('cart_update_'.$cartItem->getId(), (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        $quantity = $request->request->getInt('quantity', 1);
        $cartService->updateQuantity($cartItem, $quantity);
        $activityLogger->log($this->getUser(), 'cart_update', sprintf('Mise à jour du panier pour "%s"', $cartItem->getLivre()?->getTitre()));
        $this->addFlash('Success', 'Le panier a été mis à jour.');

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function remove(
        Request $request,
        CartItem $cartItem,
        CartService $cartService,
        ActivityLogger $activityLogger,
    ): RedirectResponse {
        $this->denyIfNotOwnedByCurrentUser($cartItem);

        if (!$this->isCsrfTokenValid('cart_remove_'.$cartItem->getId(), (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        $title = $cartItem->getLivre()?->getTitre() ?? 'ce livre';
        $cartService->removeItem($cartItem);
        $activityLogger->log($this->getUser(), 'cart_remove', sprintf('Suppression de "%s" du panier', $title));
        $this->addFlash('Success', sprintf('"%s" a été retiré du panier.', $title));

        return $this->redirectToRoute('cart_index');
    }

    private function denyIfNotOwnedByCurrentUser(CartItem $cartItem): void
    {
        $currentUser = $this->getUser();

        if (!$currentUser instanceof User || $cartItem->getUser()?->getId() !== $currentUser->getId()) {
            throw $this->createAccessDeniedException('Ce panier ne vous appartient pas.');
        }
    }
}
