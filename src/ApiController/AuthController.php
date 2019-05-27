<?php

namespace App\ApiController;


use App\Entity\User;
use App\Event\UserRegisterEvent;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @Rest\Route("/auth", host="api.ojbento.fr")
 */
class AuthController extends AbstractFOSRestController
{
    protected $dispatcher;
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
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
        $user = $userManager->createUser();
        $user
            ->setUsername($request->get('username'))
            ->setPhone($request->get('phone'))
            ->setLname($request->get('lname'))
            ->setFname($request->get('fname'))
            ->setCity($request->get('city'))
            ->setPlainPassword($request->get('password'))
            ->setEmail($request->get('email'))
            ->setEnabled(true)
            ->setRoles(['ROLE_USER'])
            ->setSuperAdmin(false)
        ;
        try {
            $em = $this->getDoctrine()->getManager();
            $userEvent = new UserRegisterEvent($user);
            $this->dispatcher->dispatch('user.registred', $userEvent);
            $em->persist($user);
            $em->flush();

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
     */
    public function profile()
    {
        return View::create($this->getUser(), Response::HTTP_OK);
    }


}
