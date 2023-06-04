<?php

namespace App\Controller;

use Knp\Bundle\TimeBundle\DateTimeFormatter;
use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Twig\Environment;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
    public function browse(HttpClientInterface $httpClient, CacheInterface $cache, $slug, Environment $twig): Response
    {
        $title = u(str_replace('-', ' ', $slug))->title(true);

        $mixes = $cache->get('mixes_data', function(CacheItemInterface $cacheItem) use ($httpClient) {
            $cacheItem->expiresAfter(5);
            $response = $httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
            return $response->toArray();
        });
        
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
}
