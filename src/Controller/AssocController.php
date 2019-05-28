<?php

namespace App\Controller;

use App\Entity\Assoc;
use App\Form\AssocType;
use App\Repository\AssocRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/assoc", host="admin.ojbento.fr")
 */
class AssocController extends AbstractController
{
    /**
     * @Route("/", name="assoc_index", methods={"GET"})
     */
    public function index(AssocRepository $assocRepository): Response
    {
        return $this->render('assoc/index.html.twig', [
            'assocs' => $assocRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="assoc_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $assoc = new Assoc();
        $form = $this->createForm(AssocType::class, $assoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */

            $entityManager = $this->getDoctrine()->getManager();
            $image = $assoc->getImage();
            $file = $form->get('image')->get('file')->getData();

            if ($file){
                $fileName = $this->generateUniqueFileName().'.'. $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('img_abs_path'), $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $image->setPath($this->getParameter('img_abs_path').'/'.$fileName) ;
                $image->setImgpath($this->getParameter('img_path').'/'.$fileName);
                $entityManager->persist($image);
            }else{
                $assoc->setImage(null);
            }

            $entityManager->persist($assoc);
            $entityManager->flush();

            return $this->redirectToRoute('assoc_index');
        }

        return $this->render('assoc/new.html.twig', [
            'assoc' => $assoc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="assoc_show", methods={"GET"})
     */
    public function show(Assoc $assoc): Response
    {
        return $this->render('assoc/show.html.twig', [
            'assoc' => $assoc,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="assoc_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Assoc $assoc): Response
    {
        $form = $this->createForm(AssocType::class, $assoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $image = $assoc->getImage();
            $file = $form->get('image')->get('file')->getData();

            if ($file){
                $fileName = $this->generateUniqueFileName().'.'. $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('img_abs_path'), $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $this->removeFile($image->getPath());
                $image->setPath($this->getParameter('img_abs_path').'/'.$fileName) ;
                $image->setImgpath($this->getParameter('img_path').'/'.$fileName);
                $entityManager->persist($image);
            }
            if (empty($image->getId()) && !$file ){
                $assoc->setImage(null);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('assoc_index', [
                'id' => $assoc->getId(),
            ]);
        }

        return $this->render('assoc/edit.html.twig', [
            'assoc' => $assoc,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="assoc_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Assoc $assoc): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assoc->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($assoc);
            $entityManager->flush();
        }

        return $this->redirectToRoute('assoc_index');
    }

    /**
     * @return string
     */
    function generateUniqueFileName() {
        return md5(uniqid());
    }
    private function removeFile($path){
        if(file_exists($path)){
            unlink($path);
        }
    }
}
