<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/catalogue', name: 'catalogue')]
class CatalogueController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(LivresRepository $livresRepository): Response
    {
        $livres = $livresRepository->findAll();

        return $this->render('catalogue/index.html.twig', [
            'livres' => $livres,
        ]);
    }

    #[Route('/catalogue/detail/{id}', name: '_detail_livre')]
    public function detailLivre(int $id, LivresRepository $livresRepository, Request $request, EntityManagerInterface $entityManager,
    Security $security): Response
    {
        $livre = $livresRepository->find($id);

        if (!$livre) {
            throw $this->createNotFoundException('Pas de livre trouvé');
        }

        $commentaire = new Commentaire();

        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setCreatedAt(new \DateTimeImmutable());
            $commentaire->setUser($security->getUser());
            $commentaire->setLivre($livre);

            $entityManager->persist($commentaire);
            $entityManager->flush();

            $this->addFlash('success', 'Votre commentaire a été ajouté.');
            return $this->redirectToRoute('catalogue_detail_livre', ['id' => $livre->getId()]);
        }

        return $this->render('catalogue/detailLivre.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
            'commentaires' => $livre->getCommentaires(),
        ]);
        }

}
