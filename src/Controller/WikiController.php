<?php

namespace App\Controller;

use App\Entity\Wiki;
use App\Form\WikiType;
use App\Repository\WikiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/admin', name: 'admin')]
    public function wikiAdmin(WikiRepository $wikiRepository, Request $request)
    {
        $wikis = $wikiRepository->findAll();
        return $this->render('wiki/wikiAdmin.html.twig',[
            'wikis' => $wikis
        ]);
    }

    #[Route('/new', name: 'new')]
    public function wikiNew(Request $request, EntityManagerInterface $entityManager)
    {
        if(!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('wiki_listing');
        }

        $newWiki = new Wiki();
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




}