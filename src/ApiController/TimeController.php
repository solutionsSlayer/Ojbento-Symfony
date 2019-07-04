<?php
namespace App\ApiController;
use App\Entity\Time;
use App\Repository\TimeRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/time", host="api.ojbento.fr")
 */
class TimeController extends  AbstractFOSRestController
{
    /**
     * retrieves a collection of Products resources
     * @Route("/", name="time_api", methods={ "GET" })
     * @Rest\View()
     **/
    public function index(TimeRepository $timeRepository): View
    {
        $time = $timeRepository->findAll();
        return View::create($time, Response::HTTP_OK);
    }
    /**
     * @Rest\Get(path="/{id}", name="Menushow_api")
     * @Rest\View()
     *
     * @param Time $time
     * @return View;
     */
    public function show(Time $time): View
    {
        return View::create($time, Response::HTTP_OK);
    }
}
