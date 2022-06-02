<?php

namespace App\Controller;

use App\Entity\Artiste;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtisteController extends AbstractController
{
    #[Route('/artiste/{id}', name: 'artiste', methods: ['GET'])]
    public function index(Artiste $artiste): Response
    {
        return $this->render('artiste/index.html.twig', [
            'artiste' => $artiste,
        ]);
    }
}
