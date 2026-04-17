<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserActivity;
use Doctrine\ORM\EntityManagerInterface;

class ActivityLogger
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function log(?User $user, string $action, string $description): void
    {
        if ($user === null) {
            return;
        }

        $activity = new UserActivity();
        $activity
            ->setUser($user)
            ->setAction($action)
            ->setDescription($description);

        $this->entityManager->persist($activity);
        $this->entityManager->flush();
    }
}
