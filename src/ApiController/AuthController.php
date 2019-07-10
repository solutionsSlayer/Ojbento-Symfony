<?php

namespace App\ApiController;

use App\Entity\User;
use App\Event\FilterUserRegistrationEvent;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Rest\Route("/auth", host="api.ojbento.fr")
 */
class AuthController extends AbstractFOSRestController
{
    private $eventDispatcher;

    function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Rest\Post(
     *     path="/register",
     *     name="auth_register_api"
     * )
     * @param Request $request
     * @param UserManagerInterface $userManager
     * @return View
     */
    public function register(Request $request, UserManagerInterface $userManager)
    {
        $user = new User();
        $email = $request->get('email');
        $user
            ->setFname($request->get('fname'))
            ->setLname($request->get('lname'))
            ->setUsername( $email)
            ->setPlainPassword($request->get('password'))
            ->setEmail($request->get('email'))
            ->setPhone($request->get('phone'))
            ->setCity($request->get('city'))
            ->setEnabled(false)
            ->setRoles(['ROLE_USER'])
            ->setSuperAdmin(false)
        ;
        try {
            $this->eventDispatcher->dispatch('user_registration.created', new FilterUserRegistrationEvent($user, $request));
            $userManager->updateUser($user);
            $user = $this->normalize($user);
        } catch (\Exception $e) {
            return View::create(["error" => $e->getMessage()], 500);
        }
        return View::create($user, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get(
     *     path="/profile",
     *     name="auth_profile_api"
     * )
     * @return View
     */
    public function profile()
    {
        $user = $this->getUser();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $object = $serializer->normalize($user, null,
            ['attributes' => [
                'id',
                'email',
                'username',
                'city',
                'fname',
                'lname',
                'commands' =>['commandassocs' =>
                    ['id', 'quantity',
                    'assoc' =>
                        ['id', 'quantity', 'isDish',
                        'product'=>
                            ['id', 'name'],
                        'type'=>
                            ['id', 'name'],
                        'prices'=>
                            ['id', 'value',
                            'type'=>
                                ['name', 'id']],
                    ]
                ],
                    'commandmenus'=> ['id', 'quantity',
                        'menu' =>['id', 'name']]

            ]]]);
        return View::create($object, Response::HTTP_OK);
    }

    /**
     * @Rest\Put(
     *     path="/profile/edit",
     *     name="auth_edit_profile_api"
     * )
     * @param Request $request
     * @param UserManagerInterface $userManager
     * @return View
     */
    public function profileEdit(Request $request, UserManagerInterface $userManager, UserRepository $userRepository)
    {
        $user = $userRepository->find($this->getUser());
        $user->setlname($request->get('lname'));
        $user->setfname($request->get('fname'));

        $userManager->updateUser($user);

        $user = $this->normalize($user);
        return View::create($user, Response::HTTP_OK);
    }

    private function normalize($object)
    {
        /* Serializer, normalizer exemple */

        $serializer = new Serializer([new ObjectNormalizer()]);
        $object = $serializer->normalize($object, null,
            ['attributes' => [
                'id',
                'bio',
                'email',
                'Lname',
                'Fname',
                'username',
                'roles'
            ]]);
        return $object;
    }
}
