<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'user_profile')]
    public function profile(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser(); // Récupérer l'utilisateur connecté

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Créer le formulaire
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        // Gérer la soumission
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès !');
            return $this->redirectToRoute('user_profile');
        }

        // Rendre la vue
        return $this->render('profile/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
