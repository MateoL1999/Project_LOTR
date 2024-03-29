<?php

namespace App\Controller;

use App\Repository\WikiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route ("/", name: "home")]
    public function home(WikiRepository $wikiRepository, Request $request )
    {
        $wikis = $wikiRepository->findAll();
        $lastwikis = $wikiRepository->getLastWiki();


        return $this->render('home.html.twig',[
            'wikis' => $wikis,
            'lastwikis' => $lastwikis
        ]);
    }

    #[Route ("/politique de confidentialités", name: "politique")]
    public function Politique()
    {
        return $this->render('CGU/Politique.html.twig');
    }

    #[Route ("/condition d'utilisation", name: "cgu")]
    public function CGU()
    {
        return $this->render('CGU/CGU.html.twig');
    }
    #[Route ("/Contact", name: "contact")]
    public function Contact()
    {
        return $this->render('Contact.html.twig');
    }
}