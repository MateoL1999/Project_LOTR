<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Form\CategorieEditFormType;
use App\Form\CategorieFormType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie', name: 'categorie_')]
class CategorieController extends AbstractController
{


    #[Route('/', name: 'listing')]
    public function categories(CategorieRepository $categorieRepository):Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('warning', 'Vous n\'êtes pas un administrateur');
            return $this->redirectToRoute('wiki_listing');
        }
        $categories = $categorieRepository->findAll();
        return $this->render('Categorie/categories.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/new', name: 'new')]
    public function categorieNew(Request $request, EntityManagerInterface $entityManager)
    {
        // Crée une nouvelle instance d'un genre, qu'on passera au formulaire
        $newCategorie = new Categorie();
        // Crée le formulaire en utilisant BookKindType, qui est le modèle de formulaire. Il contient
        // la liste des champs à générer
        $form = $this->createForm(CategorieFormType::class, $newCategorie);

        // Traite la requête pour vérifier si les données du formulaire sont soumises
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les données du formulaire
            $categorieToSave = $form->getData();
            // Le persist permet de préparer les requêtes (SQL) à exécuter en DB
            $entityManager->persist($categorieToSave);
            // Exécute toutes les requêtes SQL préparées précédemment
            $entityManager->flush();

            // Ajoute un message éphémère pour avertir de l'état de la demande
            $this->addFlash('success', 'Votre genre à été créé avec succès.');

            return $this->redirectToRoute('categorie_listing');
        }

        return $this->render('Categorie/categoriesEdit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/categorie/{id}/edit', name: 'edit')]
    public function categorieEdit($id, CategorieRepository $categorieRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $categorie = $categorieRepository->findOneBy(['id' => $id]);
        if (!$categorie) {
            return $this->redirectToRoute('categorie_listing');
        }
        $form = $this->createForm(CategorieEditFormType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();
        }

        return $this->render('Categorie/categoriesEdit.html.twig', [
            'categories' => $categorie,
            'form' => $form->createView()
        ]);
    }

    #[Route('categorie/{id}/delete', name: 'delete')]
    public function categorieDelete(CategorieRepository $categorieRepository, EntityManagerInterface $entityManager, $id)
    {
        $categorie = $categorieRepository->findOneBy(['id' => $id]);
        if (!$categorie) {
            return $this->redirectToRoute('categorie_listing');
        }
        $entityManager->remove($categorie);
        $entityManager->flush();
        return $this->redirectToRoute('categorie_listing');
    }
}