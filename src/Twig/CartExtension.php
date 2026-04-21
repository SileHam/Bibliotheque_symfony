<?php

namespace App\Twig;

use App\Entity\User;
use App\Service\CartService;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CartExtension extends AbstractExtension
{
    public function __construct(
        private Security $security,
        private CartService $cartService,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('cart_item_count', [$this, 'getCartItemCount']),
        ];
    }

    public function getCartItemCount(): int
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            return 0;
        }

        return $this->cartService->countItems($user);
    }
}
