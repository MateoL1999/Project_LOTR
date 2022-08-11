<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Wiki;
use App\Form\CommentFormType;
use App\Form\wikiEditType;
use App\Form\WikiSearchFormType;
use App\Form\WikiType;
use App\Repository\CommentRepository;
use App\Repository\WikiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;

#[Route('/wiki', name: 'wiki_')]
class WikiController extends AbstractController
{
    #[Route('/', name: 'listing')]
    public function wiki(WikiRepository $wikiRepository, Request $request)
    {
        $wikis = $wikiRepository->findAll();
        return $this->render('wiki/wikiListing.html.twig',[
            'wikis' => $wikis
        ]);
    }

    #[Route('/recherche', name: 'recherche')]
    public function wikiRecherche(WikiRepository $wikiRepository, Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $form = $this->createForm(WikiSearchFormType::class);

        $form->handleRequest($request);

        $searchFormValues =[];
        if ($form->isSubmitted() && $form->isValid()) {
            $searchFormValues = $form->getData();
        }

        // utilise une méthode custom crée par nos soins du repository
        $wikis = $wikiRepository->findWikisWithCategories($searchFormValues);
        return $this->render('Recherche/Recherche.html.twig',[
            'wikis'=>$wikis,
            'form'=>$form->createView()
        ]);
    }


    #[Route('/admin', name: 'admin')]
    public function wikiAdmin(WikiRepository $wikiRepository, Request $request)
    {
        if(!$this->isGranted('ROLE_EDITEUR')){
            $this->addFlash('warning', 'Vous n\'êtes pas un administrateur');
            return $this->redirectToRoute('wiki_listing');
        }
        $wikis = $wikiRepository->findAll();
        return $this->render('wiki/wikiAdmin.html.twig',[
            'wikis' => $wikis
        ]);
    }

    #[Route('/new', name: 'new')]
    public function wikiNew(Request $request, EntityManagerInterface $entityManager)
    {
        $newWiki = new Wiki();
        $newWiki->setDate(new \DateTime('now'));
        $form = $this->createForm(WikiType::class, $newWiki);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $wikiToSave = $form->getData();
            $entityManager->persist($wikiToSave);
            $entityManager->flush();

            $this->addFlash('sucess', 'Votre article à été créé avec succés.');
            return $this->redirectToRoute('wiki_listing');
        }
        return $this->render('wiki/wikiNew.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/wiki/{id}/edit', name: 'wiki_edit')]
    public function wikiEdit($id, WikiRepository $wikiRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $wiki = $wikiRepository->findOneBy(['id' => $id]);
        if (!$wiki) {
            return $this->redirectToRoute('wiki_listing');
        }
        $form = $this->createForm(wikiEditType::class, $wiki);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($wiki);
            $entityManager->flush();
        }
        return $this->render('wiki/wikiEdit.html.twig',[
            'wikis'=> $wiki,
            'form' => $form->createView()
        ]);
    }

    #[Route('/wiki/{id}/delete',name: 'delete')]
    public function wikiDelete(WikiRepository $wikiRepository, EntityManagerInterface $entityManager,$id)
    {
        $wiki = $wikiRepository->findOneBy(['id' => $id ]);
        if (!$wiki){
            return $this->redirectToRoute('wiki_listing');
        }
        $entityManager->remove($wiki);
        $entityManager->flush();
        return $this->redirectToRoute('wiki_listing');
    }

    #[Route('/wiki/{id}', name: 'detail', methods: ['GET', 'POST'])]
    public function bookDetail ($id, WikiRepository $wikiRepository, CommentRepository $commentRepository, Request $request, EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
    {
        $wiki = $wikiRepository->findOneWikiByIdAndCategories($id);

        if (!$wiki) {
            $this->addFlash('warning', 'Aucun livre trouvé.');
            return $this->redirectToRoute('wiki_listing');
        }

        $user = $this->getUser();
        $comment = new Comment();

        $newComment= $this->createForm(CommentFormType::class, $comment);
        $newComment->handleRequest($request);

        if($newComment->isSubmitted() && $newComment->isValid())
        {
            $comment->setWiki($wiki);
            $comment->setUser($user);

            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('sucess', "Le commentaire est publié.");
            return $this ->redirectToRoute('wiki_detail',[
               'id' => $id
            ]);
        }

        return $this->render('wiki/wikiDetail.html.twig', [
            'wiki' => $wiki,
            'newComment'=> $newComment->createView()
        ]);
    }

}