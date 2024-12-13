<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Repository\LivresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function detailLivre(int $id, LivresRepository $livresRepository): Response
    {
        $livre = $livresRepository->find($id);

        if (!$livre) {
            throw $this->createNotFoundException('Pas de livre trouvé');
        }
        return $this->render('catalogue/detailLivre.html.twig', [
            'livre' => $livre,
        ]);
    }

}
