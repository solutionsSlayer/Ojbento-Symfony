<?php

namespace App\Controller;

use App\Entity\Commandmenu;
use App\Form\CommandmenuType;
use App\Repository\CommandmenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commandmenu")
 */
class CommandmenuController extends AbstractController
{
    /**
     * @Route("/", name="commandmenu_index", methods={"GET"})
     */
    public function index(CommandmenuRepository $commandmenuRepository): Response
    {
        return $this->render('commandmenu/index.html.twig', [
            'commandmenus' => $commandmenuRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commandmenu_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commandmenu = new Commandmenu();
        $form = $this->createForm(CommandmenuType::class, $commandmenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commandmenu);
            $entityManager->flush();

            return $this->redirectToRoute('commandmenu_index');
        }

        return $this->render('commandmenu/new.html.twig', [
            'commandmenu' => $commandmenu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commandmenu_show", methods={"GET"})
     */
    public function show(Commandmenu $commandmenu): Response
    {
        return $this->render('commandmenu/show.html.twig', [
            'commandmenu' => $commandmenu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commandmenu_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commandmenu $commandmenu): Response
    {
        $form = $this->createForm(CommandmenuType::class, $commandmenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commandmenu_index', [
                'id' => $commandmenu->getId(),
            ]);
        }

        return $this->render('commandmenu/edit.html.twig', [
            'commandmenu' => $commandmenu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commandmenu_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Commandmenu $commandmenu): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandmenu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandmenu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commandmenu_index');
    }
}
