<?php
namespace App\ApiController;
use App\Entity\Assoc;
use App\Repository\AssocRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/assoc", host="api.ojbento.fr")
 */
class AssocController extends  AbstractFOSRestController
{
    /**
     * retrieves a collection of Assoc resources
     * @Route("/", name="assoc_api", methods={ "GET" })
     * @Rest\View()
     **/
    public function index(AssocRepository $assocRepository): View
    {
        $results = $assocRepository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK
        // response with the collection of task object
        $serializer = new Serializer([new ObjectNormalizer()]);

        $assocs = [];
        foreach ( $results as $assoc )
        {
            $d = $serializer->normalize($assoc, null,
                ['attributes' => [
                    'id',
                    'quantity',
                    'isDish',
                    'forMenu',
                    'description',
                    'composition',
                    'image' => [ 'id', 'imgpath'],
                    'product' => [
                        'id', 'name'],
                    'type' =>['id', 'name'],
                    'prices'=>['id', 'value', 'type'=>['name','value']]
                ],
                    'allergens' => [ 'id', 'name', 'image' => [ 'id', 'path', 'imgpath', 'alt']]
                ]);
            array_push( $assocs, $d);
        }

        return View::create($assocs, Response::HTTP_OK);
    }
    /**
     * @Rest\Get(path="/{id}", name="Assocshow_api")
     * @Rest\View()
     *
     * @param Assoc $assoc
     * @return View;
     */
    public function show(Assoc $assoc): View
    {
        return View::create($assoc, Response::HTTP_OK);
    }
}
