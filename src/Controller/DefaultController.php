<?php
namespace App\Controller;
use App\Entity\User;
use App\Repository\CommandRepository;
use App\Repository\UserRepository;
use FOS\UserBundle\Model\UserManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/", host="admin.ojbento.fr")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(CommandRepository $commandRepository, UserRepository $user)
    {
        $users = $user->findAll();
        $commands = $commandRepository->findAll();
        return $this->render('base.html.twig', [
            'users' => $users,
            'userCountActive' => 0,
            'usercount' => 0,
            'commands' => $commands,
            'count' => 0,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR]);
    }
    /**
     * @Route("/admin", name="homeAdmin")
     * @IsGranted'"ROLE_ADMIN")
     */
    public function indexAdmin()
    {

        return $this->render('base.html.twig', [

            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR]);
    }

    /**
     * @Route("/redirectionTo", name="redirectTo")
     */
    public function redirection()
    {
        $user = $this->getUser();
        if($user->hasRole('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('fos_user_profile_show');
        }

        return $this->redirectToRoute('to_ng');
    }
}
