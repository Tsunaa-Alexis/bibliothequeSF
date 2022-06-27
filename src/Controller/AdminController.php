<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\EditUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/listeUsers', name: 'listeUsers')]
    public function listeUsers(ManagerRegistry $doctrine): Response
    {

        $arrayUsers = $doctrine->getRepository(User::class)->findAll();

        return $this->render('admin/listeUsers.html.twig', [
            'arrayUsers' => $arrayUsers,
        ]);

    }

    #[Route('/editUser/{id}', name: 'editUser')]
    public function editUser(User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();

        }

        return $this->render('admin/editUser.html.twig', [
            'editUserForm' => $form->createView(),
        ]);

    }

    public function SwitchUserInterface(ManagerRegistry $doctrine){

        $user = $this->getUser();

        $arrayUsers = $doctrine->getRepository(User::class)->getListOfUser('u', ['id' => $user->getId()], "u.id != :id ");

        return $this->render(
            'admin/switchUserInterface.html.twig',
            ['arrayUsers' => $arrayUsers]
        );

    }

}
