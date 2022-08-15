<?php

namespace App\Controller;

use App\Repository\WikiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route ("/", name: "home")]
    public function home(WikiRepository $wikiRepository, Request $request)
    {
        $wikis = $wikiRepository->findAll();
        $lastwikis = $wikiRepository->getLastWiki();

        return $this->render('home.html.twig',[
            'wikis' => $wikis,
            'lastwikis' => $lastwikis
        ]);
    }

    #[Route ("/Politique de confidentialités", name: "Politique")]
    public function Politique()
    {
        return $this->render('CGU/Politique.html.twig');
    }

    #[Route ("/Condition d'utilisation", name: "CGU")]
    public function CGU()
    {
        return $this->render('CGU/CGU.html.twig');
    }
    #[Route ("/Contact", name: "Contact")]
    public function Contact()
    {
        return $this->render('Contact.html.twig');
    }
}