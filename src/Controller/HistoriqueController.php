<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Emprunt;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HistoriqueController extends AbstractController
{
    #[IsGranted('ROLE_ABONNE')]
    #[Route('/historique/emprunts', name: 'historique_emprunts')]
    public function index(EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour consulter votre historique d\'emprunts.');
            return $this->redirectToRoute('app_login');
        }

        // Récupérer tous les emprunts de l'utilisateur connecté
        $emprunts = $entityManager->getRepository(Emprunt::class)->findBy(['user' => $user], ['dateEmprunt' => 'DESC']);

        return $this->render('emprunt_historique/index.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }
}
