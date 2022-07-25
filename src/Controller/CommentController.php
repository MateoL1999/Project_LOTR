<?php

namespace App\Controller;
use App\Form\commentEditType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment', name: 'comment_')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'listing')]
    public function comment(CommentRepository $commentRepository, Request $request)
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            $this->addFlash('warning', 'Vous n\'êtes pas un administrateur');
            return $this->redirectToRoute('home');
        }
        $comments= $commentRepository->findAll();
        return $this->render('Comment/commentAdmin.html.twig',[
            'comments' => $comments
        ]);
    }

    #[Route('/comment/{id}/edit', name:'edit')]
    public function wikiEdit($id, CommentRepository $commentRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $comment = $commentRepository->findOneBy(['id' => $id]);
        if(!$comment){
            $this->addFlash('warning', 'Le commentaire est vide ');
            return $this->redirectToRoute('comment_listing');
        }
        $form=$this->createForm(commentEditType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('sucess','Le commentaire à bien était modifier');
            return $this->redirectToRoute('comment_listing');
        }
        return $this->render('comment/commentEdit.html.twig',[
            'comments' => $comment,
            'form' => $form->createView()
        ]);

    }

    #[Route('/comment/{id}/delete',name: 'delete')]
    public function commentDelete(CommentRepository $commentRepository, EntityManagerInterface $entityManager,$id)
    {
        $comment = $commentRepository->findOneBy(['id' => $id]);
        if(!$comment){
            $this->addFlash( 'success', 'Le Commentaire à était effacé avec succés');
            return $this->redirectToRoute('comment_listing');
            }
        return $this->redirectToRoute('comment_listing',[
            'comment' => $comment
        ]);

    }
}