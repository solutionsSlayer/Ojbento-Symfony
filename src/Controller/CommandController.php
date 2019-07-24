<?php

namespace App\Controller;

use App\Entity\State;
use App\Event\StateCommandEvent;
use App\Repository\CommandmenuRepository;
use App\Repository\StateRepository;
use App\Repository\TimeRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Entity\Command;
use App\Form\CommandType;
use App\Repository\CommandRepository;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function index(CommandRepository $commandRepository, TimeRepository $timeRepository): Response
    {
        $currentUser = $this->getUser();
        $uniqueKey = $this->generateUniqueKey();
        $currentUser->setApikey($uniqueKey);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($currentUser);
        $entityManager->flush();
        return $this->render('command/index.html.twig', [
            'commands' => $commandRepository->findAll(),
            'count' => 0,
            'api_key' => $uniqueKey,
            'times' => $timeRepository->findAll(),
            'count2' => 0
        ]);
    }

    /**
     * @Route("/{id}/status", name="command_patch", methods={"PATCH"})
     */
    public function patchCommandStatus(Request $request, Command $command, StateRepository $stateRepository): Response
    {
        $apikey = $request->get('apikey');
        $user = $this->getUser();
        if ($apikey == $user->getApikey()) {
            if ($command){
                $form = $this->createForm(CommandType::class, $command);
                $form->submit($request->request->all(), false);
                $em = $this->getDoctrine()->getManager();
                $stateId = $request->get('state');
                $state = $stateRepository->findOneBy(array("value" => $stateId));
                $command->setState($state);
                $CommandEvent = new StateCommandEvent($this->getUser());
                if ($state->getValue() == State::STATUS_ACCEPTED){
                    $this->dispatcher->dispatch('command.accepted', $CommandEvent);
                }
                if ($state->getValue() == State::STATUS_REFUSED){
                    $this->dispatcher->dispatch('command.denied', $CommandEvent);
                }
                if ($state->getValue() == State::STATUS_FINISHED) {
                    $this->dispatcher->dispatch('command.ready', $CommandEvent);

                }
                $em->persist($command);
                $em->flush();
                return new JsonResponse([ 'status' => 'success'],202);
            }
        }
        return new JsonResponse([],403);
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

    function generateUniqueKey() {
        return sprintf('%s%s', md5(uniqid()),sha1(uniqid()));
    }
}
