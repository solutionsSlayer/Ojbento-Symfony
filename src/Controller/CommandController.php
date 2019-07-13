<?php

namespace App\Controller;

use App\Event\StateCommandEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Entity\Command;
use App\Form\CommandType;
use App\Repository\CommandRepository;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/command", host="admin.ojbento.fr")
 */
class CommandController extends AbstractController
{
    protected $dispatcher;
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    /**
     * @Route("/", name="command_index", methods={"GET"})
     */
    public function index(CommandRepository $commandRepository): Response
    {
        return $this->render('command/index.html.twig', [
            'commands' => $commandRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="command_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $command = new Command();
        $currentUser = $this->getUser();
        $command->setUser($currentUser);
        $form = $this->createForm(CommandType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($command);
            $entityManager->flush();

            return $this->redirectToRoute('command_index');
        }

        return $this->render('command/new.html.twig', [
            'command' => $command,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="command_show", methods={"GET"})
     */
    public function show(Command $command): Response
    {
        return $this->render('command/show.html.twig', [
            'command' => $command,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="command_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Command $command): Response
    {
        $form = $this->createForm(CommandType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('command_index', [
                'id' => $command->getId(),
            ]);
        }

        return $this->render('command/edit.html.twig', [
            'command' => $command,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="command_edit", methods={"PATCH"})
     */
    public function patch(Request $request, Command $command): Response
    {
        if ($command){
            $form = $this->createForm(CommandType::class, $command);
            $form->submit($request->request->all(), false);
            $em = $this->getDoctrine()->getManager();
            $state = $request->get('state');
            if ($state == 2){
                $CommandEvent = new StateCommandEvent($this->getUser());
                $this->dispatcher->dispatch('command.accepted', $CommandEvent);
                $em->persist($command);
                $em->flush();
            }
            if ($state == 3){
                $CommandEvent = new StateCommandEvent($this->getUser());
                $this->dispatcher->dispatch('command.denied', $CommandEvent);
                $em->persist($command);
                $em->flush();
            }
        }
        return $this->redirectToRoute('command_index');
    }
    /**
     * @Route("/{id}", name="command_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Command $command): Response
    {
        if ($this->isCsrfTokenValid('delete'.$command->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($command);
            $entityManager->flush();
        }

        return $this->redirectToRoute('command_index');
    }
}
