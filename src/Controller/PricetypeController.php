<?php

namespace App\Controller;

use App\Entity\Pricetype;
use App\Form\PricetypeType;
use App\Repository\PricetypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pricetype", host="admin.ojbento.fr")
 */
class PricetypeController extends AbstractController
{
    /**
     * @Route("/", name="pricetype_index", methods={"GET"})
     */
    public function index(PricetypeRepository $pricetypeRepository): Response
    {
        return $this->render('pricetype/index.html.twig', [
            'pricetypes' => $pricetypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pricetype_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pricetype = new Pricetype();
        $form = $this->createForm(PricetypeType::class, $pricetype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pricetype);
            $entityManager->flush();

            return $this->redirectToRoute('pricetype_index');
        }

        return $this->render('pricetype/new.html.twig', [
            'pricetype' => $pricetype,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pricetype_show", methods={"GET"})
     */
    public function show(Pricetype $pricetype): Response
    {
        return $this->render('pricetype/show.html.twig', [
            'pricetype' => $pricetype,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pricetype_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pricetype $pricetype): Response
    {
        $form = $this->createForm(PricetypeType::class, $pricetype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pricetype_index', [
                'id' => $pricetype->getId(),
            ]);
        }

        return $this->render('pricetype/edit.html.twig', [
            'pricetype' => $pricetype,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pricetype_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Pricetype $pricetype): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pricetype->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pricetype);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pricetype_index');
    }
}
