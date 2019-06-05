<?php

namespace App\Controller;

use App\Entity\Time;
use App\Form\TimeType;
use App\Repository\TimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/time")
 */
class TimeController extends AbstractController
{
    /**
     * @Route("/", name="time_index", methods={"GET"})
     */
    public function index(TimeRepository $timeRepository): Response
    {
        return $this->render('time/index.html.twig', [
            'times' => $timeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="time_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $time = new Time();
        $form = $this->createForm(TimeType::class, $time);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($time);
            $entityManager->flush();

            return $this->redirectToRoute('time_index');
        }

        return $this->render('time/new.html.twig', [
            'time' => $time,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="time_show", methods={"GET"})
     */
    public function show(Time $time): Response
    {
        return $this->render('time/show.html.twig', [
            'time' => $time,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="time_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Time $time): Response
    {
        $form = $this->createForm(TimeType::class, $time);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('time_index', [
                'id' => $time->getId(),
            ]);
        }

        return $this->render('time/edit.html.twig', [
            'time' => $time,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="time_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Time $time): Response
    {
        if ($this->isCsrfTokenValid('delete'.$time->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($time);
            $entityManager->flush();
        }

        return $this->redirectToRoute('time_index');
    }
}
