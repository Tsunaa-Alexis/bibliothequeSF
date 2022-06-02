<?php

namespace App\Controller;

use App\Entity\Documents;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentsController extends AbstractController
{
    #[Route('/documents', name: 'listeDocuments')]
    public function listeDocuments(ManagerRegistry $doctrine): Response
    {

        $arrayDocuments = $doctrine->getRepository(Documents::class)->findAll();

        return $this->render('documents/listeDocuments.html.twig', [
            'arrayDocuments' => $arrayDocuments,
        ]);
    }

    #[Route('/document/{id}', name: 'documentInfos', methods: ['GET'])]
    public function documentInfos(Documents $document): Response
    { 
        return $this->render('documents/documentInfos.html.twig', [
            'document' => $document,
        ]);
    }
}
