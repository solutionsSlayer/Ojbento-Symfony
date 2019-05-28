<?php

namespace App\ApiController;

use App\Entity\Command;
use App\Form\CommandType;
use App\Repository\CommandRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Rest\Route("/command", host="api.ojbento.fr")
 */
class CommandController extends AbstractFOSRestController
{
    /**
     * Retrieves a collection of Command resource
     * @Rest\Get(
     *     path = "/",
     *     name = "command_list_api",
     * )
     * @Rest\View()
     */
    public function index(CommandRepository $commandRepository): View
    {
        $results = $commandRepository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK
        // response with the collection of task object
        $serializer = new Serializer([new ObjectNormalizer()]);

        $commands = [];
        foreach ( $results as $command ) {
            $d = $serializer->normalize($command, null,
                ['attributes' => [
                    'id',
                    'user' => [ 'id' ],
                    'commandassocs' => ['id', 'quantity',
                        'assoc' => ['id', 'quantity', 'isDish',
                            'product'=>['id', 'name'],
                            'type'=>['id', 'name'],
                            'prices'=>['id', 'value',
                                'type'=>['name', 'id']]

                        ]]
                ]]);
            array_push($commands, $d);
        }
        return View::create($commands, Response::HTTP_OK);
    }

    /**
     * Retrieves a Command
     * @Rest\Get(
     *     path = "/{id}",
     *     name = "command_show_api",
     * )
     * @Rest\View()
     */
    public function show(Command $command): View
    {
        return View::create($command, Response::HTTP_OK);
    }

    /**
     * Create a command
     * @Rest\Post(
     *     path = "/new",
     *     name = "command_create_api",
     * )
     * @param Request $request
     * @Rest\View()
     * @return View;
     */
    public function create(Request $request): View
    {
        $command = new Command();
        $command->setUser($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($command);
        $em->flush();
        return View::create($command, Response::HTTP_CREATED);
    }

//    /**
//     * Edit a Priority
//     * @Rest\Put(
//     *     path = "/{id}",
//     *     name = "priority_edit_api",
//     * )
//     * @Rest\View()
//     *
//     * @param Request $request
//     * @param Priority $priority
//     * @return View;
//     */
//    public function edit(Request $request, Priority $priority): View
//    {
//        if ($priority){
//            $priority->setName($request->get('name'));
//            $priority->setValue($request->get('value'));
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($priority);
//            $em->flush();
//        }
//        return View::create($priority, Response::HTTP_OK);
//    }
//
//    /**
//     * Edit a Priority
//     * @Rest\Patch(
//     *     path = "/{id}",
//     *     name = "priority_patch_api",
//     * )
//     * @Rest\View()
//     *
//     * @param Request $request
//     * @param Priority $priority
//     * @return View;
//     */
//    public function patch(Request $request, Priority $priority): View
//    {
//        if ($priority){
//            $form = $this->createForm(PriorityType::class, $priority);
//            $form->submit($request->request->all(), false);
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($priority);
//            $em->flush();
//        }
//        return View::create($priority, Response::HTTP_OK);
//    }
//
//    /**
//     * Delete a Priority
//     * @Rest\Delete(
//     *     path = "/{id}",
//     *     name = "priority_delete_api",
//     * )
//     * @Rest\View()
//     *
//     * @param Priority $priority
//     * @return View;
//     */
//    public function delete(Priority $priority): View
//    {
//        if ($priority){
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($priority);
//            $em->flush();
//        }
//        return View::create([], Response::HTTP_NO_CONTENT);
//    }
}
