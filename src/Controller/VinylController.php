<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function homepage(): Response
    {
        return $this->render('vinyl/home.html.twig', [
            'title' => 'Home'
        ]);
    }

    #[Route('/browse/{slug?}', name: 'browse')]
    public function browse($slug): Response
    {
        $title = u(str_replace('-', ' ', $slug))->title(true);

        return $this->render('vinyl/browse.html.twig', [
            'title' => $title
        ]);
    }

    #[Route('/show-all', name: 'show_all')]
    public function showAll(): Response
    {
        $tracks = [
            ['title' => 'Anxiety', 'singer' => 'Marron 5'],
            ['title' => 'Blind Lights', 'singer' => 'Weeknd'],
            ['title' => 'We are the world', 'singer' => 'Michael Jackson'],
        ];

        return $this->render('vinyl/show_all.html.twig', [
            'tracks' => $tracks,
        ]);
    }
}
