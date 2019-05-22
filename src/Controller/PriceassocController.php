<?php

namespace App\Controller;

use App\Entity\Priceassoc;
use App\Form\PriceassocType;
use App\Repository\PriceassocRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/priceassoc")
 */
class PriceassocController extends AbstractController
{
    /**
     * @Route("/", name="priceassoc_index", methods={"GET"})
     */
    public function index(PriceassocRepository $priceassocRepository): Response
    {
        return $this->render('priceassoc/index.html.twig', [
            'priceassocs' => $priceassocRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="priceassoc_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $priceassoc = new Priceassoc();
        $form = $this->createForm(PriceassocType::class, $priceassoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($priceassoc);
            $entityManager->flush();

            return $this->redirectToRoute('priceassoc_index');
        }

        return $this->render('priceassoc/new.html.twig', [
            'priceassoc' => $priceassoc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="priceassoc_show", methods={"GET"})
     */
    public function show(Priceassoc $priceassoc): Response
    {
        return $this->render('priceassoc/show.html.twig', [
            'priceassoc' => $priceassoc,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="priceassoc_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Priceassoc $priceassoc): Response
    {
        $form = $this->createForm(PriceassocType::class, $priceassoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('priceassoc_index', [
                'id' => $priceassoc->getId(),
            ]);
        }

        return $this->render('priceassoc/edit.html.twig', [
            'priceassoc' => $priceassoc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="priceassoc_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Priceassoc $priceassoc): Response
    {
        if ($this->isCsrfTokenValid('delete'.$priceassoc->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($priceassoc);
            $entityManager->flush();
        }

        return $this->redirectToRoute('priceassoc_index');
    }
}
