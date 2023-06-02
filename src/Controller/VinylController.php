<?php

namespace App\Controller;

use Knp\Bundle\TimeBundle\DateTimeFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

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
    public function browse(DateTimeFormatter $timeFormatter, $slug, Environment $twig): Response
    {
        $title = u(str_replace('-', ' ', $slug))->title(true);
        $mixes = $this->getMixes();

        foreach ($mixes as $key => $mix) {
            $mixes[$key]['ago'] = $timeFormatter->formatDiff($mix['createdAt']);
        }

        $html = $twig->render('vinyl/browse.html.twig', [
            'title' => $title,
            'mixes' => $mixes
        ]);

        return new Response($html);
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

    private function getMixes(): array
    {
        // temporary fake "mixes" data
        return [
            [
                'title' => 'PB & Jams',
                'trackCount' => 14,
                'genre' => 'Rock',
                'createdAt' => new \DateTime('2021-10-02'),
            ],
            [
                'title' => 'Put a Hex on your Ex',
                'trackCount' => 8,
                'genre' => 'Heavy Metal',
                'createdAt' => new \DateTime('2022-04-28'),
            ],
            [
                'title' => 'Spice Grills - Summer Tunes',
                'trackCount' => 10,
                'genre' => 'Pop',
                'createdAt' => new \DateTime('2019-06-20'),
            ],
        ];
    }
}
