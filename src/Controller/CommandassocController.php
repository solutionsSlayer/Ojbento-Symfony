<?php

namespace App\Controller;

use App\Entity\Commandassoc;
use App\Form\CommandassocType;
use App\Repository\CommandassocRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commandassoc")
 */
class CommandassocController extends AbstractController
{
    /**
     * @Route("/", name="commandassoc_index", methods={"GET"})
     */
    public function index(CommandassocRepository $commandassocRepository): Response
    {
        return $this->render('commandassoc/index.html.twig', [
            'commandassocs' => $commandassocRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commandassoc_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commandassoc = new Commandassoc();
        $form = $this->createForm(CommandassocType::class, $commandassoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commandassoc);
            $entityManager->flush();

            return $this->redirectToRoute('commandassoc_index');
        }

        return $this->render('commandassoc/new.html.twig', [
            'commandassoc' => $commandassoc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commandassoc_show", methods={"GET"})
     */
    public function show(Commandassoc $commandassoc): Response
    {
        return $this->render('commandassoc/show.html.twig', [
            'commandassoc' => $commandassoc,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commandassoc_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commandassoc $commandassoc): Response
    {
        $form = $this->createForm(CommandassocType::class, $commandassoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commandassoc_index', [
                'id' => $commandassoc->getId(),
            ]);
        }

        return $this->render('commandassoc/edit.html.twig', [
            'commandassoc' => $commandassoc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commandassoc_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Commandassoc $commandassoc): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandassoc->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandassoc);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commandassoc_index');
    }
}
