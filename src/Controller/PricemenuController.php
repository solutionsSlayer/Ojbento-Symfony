<?php

namespace App\Controller;

use App\Entity\Pricemenu;
use App\Form\PricemenuType;
use App\Repository\PricemenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pricemenu", host="admin.ojbento.fr")
 */
class PricemenuController extends AbstractController
{
    /**
     * @Route("/", name="pricemenu_index", methods={"GET"})
     */
    public function index(PricemenuRepository $pricemenuRepository): Response
    {
        return $this->render('pricemenu/index.html.twig', [
            'pricemenus' => $pricemenuRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pricemenu_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pricemenu = new Pricemenu();
        $form = $this->createForm(PricemenuType::class, $pricemenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pricemenu);
            $entityManager->flush();

            return $this->redirectToRoute('pricemenu_index');
        }

        return $this->render('pricemenu/new.html.twig', [
            'pricemenu' => $pricemenu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pricemenu_show", methods={"GET"})
     */
    public function show(Pricemenu $pricemenu): Response
    {
        return $this->render('pricemenu/show.html.twig', [
            'pricemenu' => $pricemenu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pricemenu_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pricemenu $pricemenu): Response
    {
        $form = $this->createForm(PricemenuType::class, $pricemenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pricemenu_index', [
                'id' => $pricemenu->getId(),
            ]);
        }

        return $this->render('pricemenu/edit.html.twig', [
            'pricemenu' => $pricemenu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pricemenu_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Pricemenu $pricemenu): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pricemenu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pricemenu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pricemenu_index');
    }
}
