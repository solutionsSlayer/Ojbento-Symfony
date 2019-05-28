<?php

namespace App\ApiController;

use App\Entity\Commandassoc;
use App\Form\CommandassocType;
use App\Repository\AssocRepository;
use App\Repository\CommandassocRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CommandRepository;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Rest\Route("/commandassoc", host="api.ojbento.fr")
 */
class CommandassocController extends AbstractFOSRestController
{
    /**
     * Retrieves a collection of command resource
     * @Rest\Get(
     *     path = "/",
     *     name = "commandassoc_list_api",
     * )
     * @Rest\View()
     */
    public function index(CommandassocRepository $commandassocRepository): View
    {
        $results = $commandassocRepository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK
        // response with the collection of task object
        $serializer = new Serializer([new ObjectNormalizer()]);

        $commandsassoc = [];
        foreach ( $results as $type ) {
            $d = $serializer->normalize($type, null,
                ['attributes' => [
                    'id',
                    'quantity',
                    'commandsassoc' => ['id', 'quantity', 'type' => ['name'], 'isDish', 'description', 'composition', 'product' => [
                        'id', 'name'
                    ]]
                ]]);
            array_push($commandsassoc, $d);
        }
        return View::create($commandsassoc, Response::HTTP_OK);
    }

    /**
     * Retrieves a commandassoc
     * @Rest\Get(
     *     path = "/{id}",
     *     name = "commandassoc_show_api",
     * )
     * @Rest\View()
     */
    public function show(Commandassoc $commandassoc): View
    {
        return View::create($commandassoc, Response::HTTP_OK);
    }

    /**
     * Create a commandassoc
     * @Rest\Post(
     *     path = "/new",
     *     name = "commandassoc_create_api",
     * )
     * @param Request $request
     * @Rest\View()
     * @return View;
     */
    public function create(Request $request, AssocRepository $assocRepository, CommandRepository $commandRepository): View
    {
        $commandassoc = new Commandassoc();
        $commandassoc->setQuantity($request->get('quantity'));
        $assoc = $assocRepository->find($request->get('assoc'));
        $commandassoc->setAssoc($assoc);
        $command = $commandRepository->find($request->get('command'));
        $commandassoc->setCommand($command);
        $em = $this->getDoctrine()->getManager();
        $em->persist($commandassoc);
        $em->flush();
        return View::create($commandassoc, Response::HTTP_CREATED);
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
