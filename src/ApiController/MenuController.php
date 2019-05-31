<?php
namespace App\ApiController;
use App\Entity\Menu;
use App\Repository\MenuRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/menu", host="api.ojbento.fr")
 */
class MenuController extends  AbstractFOSRestController
{
    /**
     * retrieves a collection of Products resources
     * @Route("/", name="menu_api", methods={ "GET" })
     * @Rest\View()
     **/
    public function index(MenuRepository $menuRepository): View
    {
        $results = $menuRepository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK
        // response with the collection of task object
        $serializer = new Serializer([new ObjectNormalizer()]);

        $menus = [];
        foreach ( $results as $menu )
        {
            $d = $serializer->normalize($menu, null,
                ['attributes' => [
                    'id',
                    'name',
                    'isMidi',
                    'assocs' => [
                        'id', 'type'=>['id','name'], 'description', 'composition'],
                     'prices'=>['id', 'value', 'type'=>['name']]
                ]]);
            array_push( $menus, $d);
        }
        return View::create($menus, Response::HTTP_OK);
    }
    /**
     * @Rest\Get(path="/{id}", name="Menushow_api")
     * @Rest\View()
     *
     * @param Menu $menu
     * @return View;
     */
    public function show(Menu $menu): View
    {
        return View::create($menu, Response::HTTP_OK);
    }
}
