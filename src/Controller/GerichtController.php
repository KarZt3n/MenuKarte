<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Form\GerichtEditType;
use App\Form\GerichtType;
use App\Repository\GerichtRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gericht", name="gericht.")
 */
class GerichtController extends AbstractController
{

    private $doctrine;

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/", name="bearbeiten")
     */
    public function index(GerichtRepository $gerichtRepository): Response
    {
        $gerichte = $gerichtRepository->findAll();
        return $this->render('gericht/index.html.twig', [
            'gerichte' => $gerichte,
        ]);
    }

    /**
     * @Route("/anlegen", name="anlegen")
     */
    public function addGericht(Request $request){
        $gericht = new Gericht();
        $form = $this->createForm(GerichtType::class, $gericht);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            //EntityManager
            $em = $this->doctrine->getManager();
            $bild = $form->get('bild')->getData();
            if ($bild){
                $dateiname = md5(uniqid()). '.' . $bild->guessClientExtension();
            }
            $bild->move(
                $this->getParameter('bilder_ordner'),
                $dateiname
            );
            $gericht->setReihenfolge(0);
            $gericht->setBild($dateiname);

            $em->persist($gericht);
            $em->flush();

            return $this->redirect($this->generateUrl('gericht.bearbeiten'));
        }

//        $gericht->setName('Pizza');
//        $gericht->setBeschreibung('Salami, Käse');

        //Response
        return $this->render('gericht/anlegen.html.twig', [
            'anlegenForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Gericht $gericht, GerichtRepository $gerichtRepository): Response
    {
        $form = $this->createForm(GerichtEditType::class, $gericht);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gerichtRepository->add($gericht, true);

            return $this->redirectToRoute('menu', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gericht/edit.html.twig', [
            'gericht' => $gericht,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="entfernen", methods={"POST"})
     */
    public function delete(Request $request, Gericht $gericht, GerichtRepository $gerichtRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gericht->getId(), $request->request->get('_token'))) {
            $gerichtRepository->remove($gericht, true);
        }

        return $this->redirectToRoute('menu', [], Response::HTTP_SEE_OTHER);
    }

//    /**
//     * @Route("/entfernen/{id}", name="entfernen")
//     */
//    public function delGericht($id, GerichtRepository $gerichtRepository){
//        $em = $this->doctrine->getManager();
//        $gericht = $gerichtRepository->find($id);
//        $em->remove($gericht);
//        $em->flush();
//
//        $this->addFlash('erfolg', 'Gericht wurde erfolgreich entfernt.');
//        return $this->redirect($this->generateUrl('gericht.bearbeiten'));
//    }

    /**
     * @Route("/anzeigen/{id}", name="anzeigen")
     */
    public function showPic(Gericht $gericht){
        return $this->render('gericht/anzeigen.html.twig', [
            'gericht' => $gericht,
        ]);
    }
}
