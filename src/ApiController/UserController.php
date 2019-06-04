<?php

namespace App\ApiController;

use App\Entity\User;
use App\Repository\CommandRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;



/**
 * @Rest\Route("/user", host="api.ojbento.fr")
 */
class UserController extends AbstractFOSRestController
{
    /**
     * Retrieves a collection of command resource
     * @Rest\Get(
     *     path = "/{id}/commands",
     *     name = "commands_user_api",
     * )
     * @Rest\View()
     */
    public function indexCommand(UserManagerInterface $userManager, User $user, CommandRepository $commandRepository)
    {

        $commands = $commandRepository->findBy(array('user' => $user));
        $serializer = new Serializer([new ObjectNormalizer()]);

        $d = $serializer->normalize($commands, null,
            ['attributes' => [

                'id',
                'commandassocs' => ['id',
                    'quantity',
                    'assoc' => [
                        'id',
                        'quantity',
                        'type' => ['name'],
                        'isDish',
                        'description',
                        'composition',
                        'product' => [
                            'id',
                            'name'],
                        'prices' => [
                            'id',
                            'value',
                            'type' => [
                                'id',
                                'name']]
                    ]],
                'commandmenus' => ['id',
                    'quantity',
                    'menu' => [
                        'id',
                        'name',
                        'isMidi',
                        'assocs' => [
                            'type' => ['name'],
                            'isDish',
                            'description',
                            'composition',
                            'product' => [
                                'id',
                                'name'],
                            'quantity'
                        ]
                    ]]


            ]]);

        return View::create($d, Response::HTTP_OK);
    }
}