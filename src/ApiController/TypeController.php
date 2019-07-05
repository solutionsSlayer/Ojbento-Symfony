<?php

namespace App\ApiController;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\CommandRepository;
use App\Repository\MenuRepository;
use App\Repository\TypeRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use symfony\component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * @Rest\Route("/type", host="api.ojbento.fr")
 */
class TypeController extends AbstractFOSRestController
{

    /**
     * Retrieves a collection of Command resource
     * @Rest\Get(
     *     path = "/",
     *     name = "type_list_api",
     * )
     * @Rest\View()
     */
    public function index(TypeRepository $typeRepository): View
    {

        $results = $typeRepository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK
        // response with the collection of task object

        $serializer = new Serializer([new ObjectNormalizer()]);

        $types = [];
        foreach ($results as $type) {
            $d = $serializer->normalize($type, null,
                ['attributes' => [
                    'id',
                    'name',
                    'assocs' => [
                        'id',
                        'quantity',
                        'isDish',
                        'description',
                        'composition',
                        'forMenu',
                        'product' => [
                            'id',
                            'name'],
                        'prices' => [
                            'id',
                            'value',
                            'type' =>['name', 'value']
                        ]
                    ]
                ]]);
            array_push($types, $d);
        }
        return View::create($types, Response::HTTP_OK);
    }

    /**
     * Retrieves a collection of Command resource
     * @Rest\Get(
     *     path = "/assocs",
     *     name = "type_list_with_assocs_api",
     * )
     * @Rest\View()
     */
    public function indexAssocs(TypeRepository $typeRepository): View
    {
        $results = $typeRepository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK
        // response with the collection of task object

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $serializer = new Serializer([$normalizer]);

        $types = [];
        foreach ($results as $type) {
            $d = $serializer->normalize($type, null,
                ['attributes' => [
                    'id',
                    'name',
                    'assocs' => ['id', 'type'=>['name'],'quantity', 'isDish', 'description', 'composition', 'product' => [
                        'id', 'name'],
                        'image' => [
                            'id',
                            'path',
                            'imgpath',
                            'alt'],
                        'forMenu',
                        'prices' => [
                            'id',
                            'value',
                            'type' =>['name', 'value']
                        ]
                    ]
                ]
                ]);
            array_push($types, $d);
        }

        return View::create($types, Response::HTTP_OK);
    }

    /**
     * Retrieves a type
     * @Rest\Get(
     *     path = "/{id}",
     *     name = "command_show_api",
     * )
     * @Rest\View()
     */
    public function show(Type $type): View
    {
        return View::create($type, Response::HTTP_OK);
    }

//    /**
//     * Create a command
//     * @Rest\Post(
//     *     path = "/new",
//     *     name = "command_create_api",
//     * )
//     * @param Request $request
//     * @Rest\View()
//     * @return View;
//     */
//    public function create(Request $request): View
//    {
//        $command = new Command();
//        $command->setUser($this->getUser());
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($command);
//        $em->flush();
//        return View::create($command, Response::HTTP_CREATED);
//    }

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
