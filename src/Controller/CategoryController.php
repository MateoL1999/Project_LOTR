<?php

namespace App\Controller;


use App\Entity\Category;
use App\Form\CategoryEditFormType;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{


    #[Route('/', name: 'listing')]
    public function category(CategoryRepository $categoryRepository):Response
    {
        if (!$this->isGranted('ROLE_EDITEUR')) {
            $this->addFlash('warning', 'Vous n\'êtes pas un administrateur');
            return $this->redirectToRoute('wiki_listing');
        }
        $category = $categoryRepository->findAll();
        return $this->render('Category/category.html.twig', [
            'categorys' => $category
        ]);
    }

    #[Route('/new', name: 'new')]
    public function categoryNew(Request $request, EntityManagerInterface $entityManager)
    {
        if(!$this->isGranted('ROLE_EDITEUR')){
            $this->addFlash('warning', 'Vous n\'êtes pas un administrateur');
            return $this->redirectToRoute('home');
        }
        // Crée une nouvelle instance d'un genre, qu'on passera au formulaire
        $newCategory = new Category();
        // Crée le formulaire en utilisant BookKindType, qui est le modèle de formulaire. Il contient
        // la liste des champs à générer
        $form = $this->createForm(CategoryFormType::class, $newCategory);

        // Traite la requête pour vérifier si les données du formulaire sont soumises
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les données du formulaire
            $categoryToSave = $form->getData();
            // Le persist permet de préparer les requêtes (SQL) à exécuter en DB
            $entityManager->persist($categoryToSave);
            // Exécute toutes les requêtes SQL préparées précédemment
            $entityManager->flush();

            // Ajoute un message éphémère pour avertir de l'état de la demande
            $this->addFlash('sucess', 'Votre catégorie à été créé avec succès.');
            return $this->redirectToRoute('category_listing');
        }

        return $this->render('Category/categoryNew.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/category/{id}/edit', name: 'edit')]
    public function categoryEdit($id, CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $entityManager)
    {
        if(!$this->isGranted('ROLE_EDITEUR')){
        $this->addFlash('warning', 'Vous n\'êtes pas un administrateur');
        return $this->redirectToRoute('home');
        }
        $category = $categoryRepository->findOneBy(['id' => $id]);
        if (!$category) {
            return $this->redirectToRoute('category_listing');
        }
        $form = $this->createForm(CategoryEditFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('sucess', "La catégorie as bien était modifié.");
            return $this->redirectToRoute('category_listing');
        }

        return $this->render('Category/categoryEdit.html.twig', [
            'categorys' => $category,
            'form' => $form->createView()
        ]);

    }

    #[Route('category/{id}/delete', name: 'delete')]
    public function categoryDelete(CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, $id)
    {
        if(!$this->isGranted('ROLE_EDITEUR')){
            $this->addFlash('warning', 'Vous n\'êtes pas un administrateur');
            return $this->redirectToRoute('home');
        }
        $category = $categoryRepository->findOneBy(['id' => $id]);
        if (!$category) {
            $this->addFlash('warning', "La catégorie n'a pas été trouvée");
            return $this->redirectToRoute('category_listing');
        }
        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash('sucess', "La catégorie a bien était supprimée");
        return $this->redirectToRoute('category_listing');
    }
}