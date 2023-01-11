<?php

namespace App\Controller;

use App\Entity\Bestellung;
use App\Entity\Gericht;
use App\Repository\BestellungRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BestellungController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }
    /**
     * @Route("/bestellung", name="bestellung")
     */
    public function index(BestellungRepository $bestellungRepository): Response
    {
        $bestellungen = $bestellungRepository->findAll();

//        if (isset($_COOKIE['cookie'])) {
//            foreach ($_COOKIE['cookie'] as $name => $value) {
//                $name = htmlspecialchars($name);
//                $value = htmlspecialchars($value);
//                echo "$name : $value <br />\n";
//            }
//        }

        return $this->render('bestellung/index.html.twig', [
            'bestellungen' => $bestellungen,
        ]);
    }

    /**
     * @Route("/bestellen/{id}", name="bestellen")
     */
    public function bestellung(Gericht $gericht){
        $tisch = 'tisch1';
        $status = 'offen';

        $bestellung = new Bestellung();
        $bestellung->setTisch($tisch);
        $bestellung->setName($gericht->getName());
        $bestellung->setBestellnummer($gericht->getId());
        $bestellung->setPreis($gericht->getPreis());
        $bestellung->setStatus($status);

        //entityManager
        $em = $this->doctrine->getManager();
        $em->persist($bestellung);
        $em->flush();

        $this->addFlash('bestell', $bestellung->getName(). ' wurde zur Bestellung hinzugefügt!');

        return $this->redirect($this->generateUrl('menu'));
    }

    /**
     * @Route("/status/{id},{status}", name="status")
     */
    public function changeStatus($id, $status){
        $em = $this->doctrine->getManager();
        $bestellung = $em->getRepository(Bestellung::class)->find($id);
        $bestellung->setStatus($status);
        $em->flush();

        return $this->redirect($this->generateUrl('bestellung'));
    }
}
