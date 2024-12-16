<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Livres;
use App\Entity\Emprunt;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/catalogue', name: 'catalogue_')]
class CatalogueController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(LivresRepository $livresRepository): Response
    {
        $livres = $livresRepository->findAll();

        return $this->render('catalogue/index.html.twig', [
            'livres' => $livres,
        ]);
    }

    #[Route('/detail/{id}', name: 'detail_livre')]
    public function detailLivre(
        int $id,
        LivresRepository $livresRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        Security $security
    ): Response {
        $livre = $livresRepository->find($id);

        if (!$livre) {
            throw $this->createNotFoundException('Pas de livre trouvé.');
        }

        // Récupération des commentaires associés au livre
        $commentaires = $livre->getCommentaires();

        // Calcul de la moyenne des notes
        $averageNote = null;
        if (count($commentaires) > 0) {
            $totalNotes = array_reduce($commentaires->toArray(), function ($sum, $comment) {
                return $sum + $comment->getNote(); // Supposant que la méthode `getNote()` existe
            }, 0);
            $averageNote = $totalNotes / count($commentaires);
        }

        // Création et gestion du formulaire de commentaire
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            dump("Formulaire soumis");  // Vérifie si le formulaire a bien été soumis
        
            if ($form->isValid()) {
                dump("Formulaire valide");  // Vérifie si le formulaire est valide
        
                $commentaire->setContent($form->get('content')->getData());
                $commentaire->setNote($form->get('note')->getData());
                $commentaire->setCreatedAt(new \DateTimeImmutable());
                $commentaire->setUser($security->getUser());
                $commentaire->setLivre($livre);
        
                $entityManager->persist($commentaire);
                $entityManager->flush();
        
                $this->addFlash('success', 'Votre commentaire a été ajouté.');
                return $this->redirectToRoute('catalogue_detail_livre', ['id' => $livre->getId()]);
            } else {
                dump("Le formulaire n'est pas valide");
            }
        } else {
            dump("Le formulaire n'a pas été soumis.");
        }

        return $this->render('catalogue/detailLivre.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
            'commentaires' => $commentaires,
            'averageNote' => $averageNote,
        ]);
    }

    #[Route('/detail/{id}/emprunter', name: 'emprunter')]
    #[IsGranted('ROLE_ABONNE')]
    public function emprunter(Livres $livre, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour emprunter un livre.');
            return $this->redirectToRoute('app_login');
        }

        // Vérifier si le livre est déjà emprunté
        $empruntActif = $entityManager->getRepository(Emprunt::class)
            ->findOneBy(['livre' => $livre, 'dateRetour' => null]);

        if ($empruntActif) {
            $this->addFlash('warning', 'Ce livre est déjà emprunté.');
            return $this->redirectToRoute('catalogue_detail_livre', ['id' => $livre->getId()]);
        }

        $emprunt = new Emprunt();
        $emprunt->setUser($user);
        $emprunt->setLivre($livre);
        $emprunt->setDateEmprunt(new \DateTime());
        $emprunt->setDateRetour(null);

        $entityManager->persist($emprunt);
        $entityManager->flush();

        $this->addFlash('success', 'Livre emprunté avec succès, bonne lecture !');
        return $this->redirectToRoute('catalogue_detail_livre', ['id' => $livre->getId()]);
    }


    #[Route('/detail/{id}/rendre', name: 'rendre')]
    #[IsGranted('ROLE_ABONNE')]
    public function rendre(Livres $livre, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour emprunter un livre.');
            return $this->redirectToRoute('app_login');
        }

        $emprunt = $entityManager->getRepository(Emprunt::class)
            ->findOneBy(['livre' => $livre, 'user' => $user, 'dateRetour' => null]);

        if (!$emprunt) {
            $this->addFlash('warning', 'Vous n\'avez pas emprunté ce livre.');
            return $this->redirectToRoute('catalogue_detail_livre', ['id' => $livre->getId()]);
        }

        // Mettre à jour la date de retour
        $emprunt->setDateRetour(new \DateTime());
        $entityManager->flush();

        $this->addFlash('success', 'Livre rendu avec succès.');
        return $this->redirectToRoute('catalogue_detail_livre', ['id' => $livre->getId()]);
    }

}
