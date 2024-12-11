<?php

namespace App\Controller;

use App\Entity\Abonnement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbonnementController extends AbstractController
{
    #[Route('/abonnement', name: 'abonnement_page')]

    #[Route('/abonnement', name: 'abonnement_page')]
    public function abonnement(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Utilisateur non authentifié.');
            return $this->redirectToRoute('app_login');
        }
    
        $dateDebut = new \DateTime();
        $dateFinMensuel = (clone $dateDebut)->modify('+1 month');
        $dateFinAnnuel = (clone $dateDebut)->modify('+1 year');
    
        $type = $request->query->get('type');
        $abonnement = null;
    
        if ($type && !in_array($type, ['mensuel', 'annuel'])) {
            $this->addFlash('error', 'Type d\'abonnement invalide.');
            return $this->redirectToRoute('abonnement_page');
        }
    
        // Vérifier si l'utilisateur a déjà un abonnement actif
        $abonnementActif = $em->getRepository(Abonnement::class)->findOneBy(['user' => $user]);
    
        if ($abonnementActif) {
            $abonnement = $abonnementActif; // Transmettre l'abonnement existant à la vue
        } elseif ($type) {
            $abonnement = new Abonnement();
            $abonnement->setDateDebut($dateDebut);
            $abonnement->setType($type);
    
            if ($type === 'mensuel') {
                $abonnement->setDateFin($dateFinMensuel);
            } else {
                $abonnement->setDateFin($dateFinAnnuel);
            }
    
            $roles = $user->getRoles();
            if (!in_array('ROLE_ABONNE', $roles)) {
                $roles[] = 'ROLE_ABONNE';
                $user->setRoles($roles);
                $em->persist($user);
            }
    
            $abonnement->setUser($user);
    
            $em->persist($abonnement);
            $em->flush();
    
            $this->addFlash('success', 'Votre abonnement a été activé avec succès !');
            return $this->redirectToRoute('abonnement_page');
        }
    
        return $this->render('abonnement/index.html.twig', [
            'dateDebut' => $dateDebut,
            'dateFinMensuel' => $dateFinMensuel,
            'dateFinAnnuel' => $dateFinAnnuel,
            'abonnement' => $abonnement,
        ]);
    }

    #[Route('/abonnement/confirmation', name: 'abonnement_confirmation')]
    public function confirmation(): Response
    {
        return $this->render('abonnement/confirmation.html.twig');
    }       
}

