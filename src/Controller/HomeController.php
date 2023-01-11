<?php

namespace App\Controller;

use App\Repository\GerichtRepository;
use App\Repository\NewsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(GerichtRepository $gerichtRepository, NewsRepository $newsRepository): Response
    {
        $gerichteAll = $gerichtRepository->findAll();
        $gerichte = [];
        if (count($gerichteAll) > 2){
            $zufall = array_rand($gerichteAll, 2);
            $gerichte[] = $gerichteAll[$zufall[0]];
            $gerichte[] = $gerichteAll[$zufall[1]];
        }

//        $lastNews = $newsRepository->findBy([],['id'=>'DESC'],1,0);
        $lastNews = $newsRepository->findLastCreateAt(new DateTime('now'));
        $newsFuture = $newsRepository->findAllEventsInFuture(new DateTime('now'));

        return $this->render('home/index.html.twig', [
            'gerichte' => $gerichte? $gerichte : [],
            'lastNews' => $lastNews? $lastNews[0]: [],
            'nextEvent' => $newsFuture? $newsFuture[0] : [],
        ]);
    }

}
