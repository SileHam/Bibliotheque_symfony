<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@bookstore.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsVerified(true);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'admin123')
        );
        $manager->persist($admin);

        $user = new User();
        $user->setEmail('user@bookstore.com');
        $user->setRoles(['ROLE_USER']);
        $user->setIsVerified(true);
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, 'user123')
        );
        $manager->persist($user);

        $manager->flush();
    }
}
