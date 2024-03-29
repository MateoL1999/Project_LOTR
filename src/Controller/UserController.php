<?php

namespace App\Controller;


use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    #[Route('/admin/users', name:'user_listing')]
    public function userListing(UserRepository $userRepository):Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            $this->addFlash('warning', 'Vous n\'êtes pas un administrateur');
            return $this->redirectToRoute('Connexion');
        }
        $users = $userRepository->findAll();
        return $this->render('user/user.html.twig',[
           'users'=> $users,
            'controller_name'=> 'UserController',
        ]);
    }

    #[Route('/users/{id}/edit', name: 'user_edit')]
    public function userEdit($id, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager)
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            $this->addFlash('warning', 'Vous n\'êtes pas un administrateur');
            return $this->redirectToRoute('home');
        }
        $user = $userRepository->findOneBy(['id' => $id]);
        if (!$user) {
            return $this->redirectToRoute('user_listing');
        }
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('sucess', "L'utilisateur a bien était modifié.");
            return $this->redirectToRoute('user_listing');
        }

        return $this->render('user/userEdit.html.twig',[
            'users'=> $user,
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/{id}/delete',name: 'user_delete')]
    public function userDelete(UserRepository $userRepository, EntityManagerInterface $entityManager,$id )
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            $this->addFlash('warning', 'Vous n\'êtes pas un administrateur');
            return $this->redirectToRoute('home');
        }
        $user = $userRepository->findOneBy(['id' => $id]);
        if (!$user){
            return $this->redirectToRoute('user_listing');
        }
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('sucess', "L'utilisateur a bien était suprimée");
        return $this->redirectToRoute('user_listing');
    }



}