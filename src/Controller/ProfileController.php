<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\UserActivityRepository;
use App\Service\ActivityLogger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/profil')]
#[IsGranted('ROLE_USER')]
class ProfileController extends AbstractController
{
    #[Route('', name: 'profile_show', methods: ['GET', 'POST'])]
    public function show(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        UserActivityRepository $activityRepository,
        ActivityLogger $activityLogger
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            if (!empty($plainPassword)) {
                $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            }

            $entityManager->flush();
            $activityLogger->log($user, 'profile_update', 'Mise a jour du profil utilisateur');

            $this->addFlash('Success', 'Votre profil a ete mis a jour.');

            return $this->redirectToRoute('profile_show');
        }

        $recentActivities = $activityRepository->findRecentForUser($user, 8);
        $lastLogin = null;

        foreach ($recentActivities as $activity) {
            if ($activity->getAction() === 'login') {
                $lastLogin = $activity;
                break;
            }
        }

        return $this->render('profile/show.html.twig', [
            'profileForm' => $form->createView(),
            'recentActivities' => $recentActivities,
            'lastLogin' => $lastLogin,
        ]);
    }
}
