<?php

namespace App\Controller;

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
}
