<?php

namespace App\Controller;

use App\Entity\Kategorie;
use App\Form\KategorieType;
use App\Repository\KategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/kategorie")
 */
class KategorieController extends AbstractController
{
    /**
     * @Route("/", name="app_kategorie_index", methods={"GET"})
     */
    public function index(KategorieRepository $kategorieRepository): Response
    {
        $kategories = $kategorieRepository->findBy(array(), array('reihenfolge' => 'ASC'));

        return $this->render('kategorie/index.html.twig', [
            'kategories' => $kategories,
        ]);
    }

    /**
     * @Route("/new", name="app_kategorie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, KategorieRepository $kategorieRepository): Response
    {
        $kategorie = new Kategorie();
        $form = $this->createForm(KategorieType::class, $kategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $kategorieRepository->add($kategorie, true);

            return $this->redirectToRoute('app_kategorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kategorie/new.html.twig', [
            'kategorie' => $kategorie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_kategorie_show", methods={"GET"})
     */
    public function show(Kategorie $kategorie): Response
    {
        return $this->render('kategorie/show.html.twig', [
            'kategorie' => $kategorie,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_kategorie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Kategorie $kategorie, KategorieRepository $kategorieRepository): Response
    {
        $form = $this->createForm(KategorieType::class, $kategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $kategorieRepository->add($kategorie, true);

            return $this->redirectToRoute('app_kategorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kategorie/edit.html.twig', [
            'kategorie' => $kategorie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_kategorie_delete", methods={"POST"})
     */
    public function delete(Request $request, Kategorie $kategorie, KategorieRepository $kategorieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$kategorie->getId(), $request->request->get('_token'))) {
            $kategorieRepository->remove($kategorie, true);
        }

        return $this->redirectToRoute('app_kategorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
