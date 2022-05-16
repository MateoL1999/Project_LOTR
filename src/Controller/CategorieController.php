<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{

#[Route('/Categorie', name: 'Categorie__listing')]
public function bookKinds(CategorieRepository $CategorieRepository)
{
    $categories = $CategorieRepository->findAll();
    return $this->render('Categorie/Categories.html.twig', [
        'categories' => $categories
    ]);
}

    #[Route('/categories/new', name: 'categorie_new')]
    public function categorieNew(Request $request, EntityManagerInterface $entityManager)
    {
        // Crée une nouvelle instance d'un genre, qu'on passera au formulaire
        $newBookKind = new Categorie();
        // Crée le formulaire en utilisant BookKindType, qui est le modèle de formulaire. Il contient
        // la liste des champs à générer
        $form = $this->createForm(CategorieType::class, $newBookKind);

        // Traite la requête pour vérifier si les données du formulaire sont soumises
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            // Récupère les données du formulaire
            $categorieToSave= $form->getData();
            // Le persist permet de préparer les requêtes (SQL) à exécuter en DB
            $entityManager->persist($categorieToSave);
            // Exécute toutes les requêtes SQL préparées précédemment
            $entityManager->flush();

            // Ajoute un message éphémère pour avertir de l'état de la demande
            $this->addFlash('success', 'Votre genre à été créé avec succès.');

            return $this->redirectToRoute('Categorie__listing');
        }

        return $this->render('Categories.html.twig', [
            'CategorieForm' => $form->createView()
        ]);
    }





}