<?php

namespace App\Service;

use App\Entity\CartItem;
use App\Entity\Livre;
use App\Entity\User;
use App\Repository\CartItemRepository;
use Doctrine\ORM\EntityManagerInterface;

class CartService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CartItemRepository $cartItemRepository,
    ) {
    }

    public function addBook(User $user, Livre $livre, int $quantity = 1): CartItem
    {
        if (!$livre->isInStock()) {
            throw new \DomainException('Ce livre est actuellement en rupture de stock.');
        }

        $quantity = max(1, $quantity);
        $cartItem = $this->cartItemRepository->findOneForUserAndBook($user, $livre);

        if ($cartItem === null) {
            $cartItem = (new CartItem())
                ->setUser($user)
                ->setLivre($livre);

            $this->entityManager->persist($cartItem);
        }

        $cartItem->setQuantity(min($livre->getStock(), $cartItem->getQuantity() + $quantity));
        $this->entityManager->flush();

        return $cartItem;
    }

    public function updateQuantity(CartItem $cartItem, int $quantity): void
    {
        $quantity = max(0, $quantity);

        if ($quantity === 0) {
            $this->removeItem($cartItem);

            return;
        }

        $maxQuantity = $cartItem->getLivre()?->getStock() ?? $quantity;
        $cartItem->setQuantity(min($maxQuantity, $quantity));
        $this->entityManager->flush();
    }

    public function removeItem(CartItem $cartItem): void
    {
        $this->entityManager->remove($cartItem);
        $this->entityManager->flush();
    }

    /**
     * @return array{items: CartItem[], totalQuantity: int, subtotal: float}
     */
    public function getCartSummary(User $user): array
    {
        $items = $this->cartItemRepository->findDetailedCartForUser($user);
        $subtotal = 0.0;
        $totalQuantity = 0;

        foreach ($items as $item) {
            $subtotal += $item->getLineTotal();
            $totalQuantity += $item->getQuantity();
        }

        return [
            'items' => $items,
            'totalQuantity' => $totalQuantity,
            'subtotal' => $subtotal,
        ];
    }

    public function countItems(?User $user): int
    {
        if (!$user instanceof User) {
            return 0;
        }

        return $this->cartItemRepository->countQuantityForUser($user);
    }
}
