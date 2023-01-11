<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Repository\GerichtRepository;
use App\Repository\KategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("/menu", name="menu")
     */
    public function menu(GerichtRepository $gerichtRepository, KategorieRepository $kategorieRepository): Response
    {
        $gerichte = $gerichtRepository->findBy(array(), array('reihenfolge' => 'ASC'));
        $kategories = $kategorieRepository->findBy(array(), array('reihenfolge' => 'ASC'));

        //check empty Kat
        foreach ($kategories as $kategorie){
            if (!$kategorie->isHide()){
                $hide = true;
                $kategorieName = $kategorie->getName();
                foreach ($gerichte as $gericht){
                    if ( $kategorieName === $gericht->getKategorie()->getName() ){
                        $hide = false;
                    }
                }
                $kategorie->setHide($hide);
            }

        }

        //check Image root: public/
        foreach ($gerichte as $gericht){
            if (!file_exists( 'fileadmin/bilder/'.$gericht->getBild() )){
                $gericht->setBild('placeholder.png');
            }
        }

        return $this->render('menu/index.html.twig', [
            'gerichte' => $gerichte,
            'kategorien' => $kategories,
        ]);
    }
}
