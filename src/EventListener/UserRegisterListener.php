<?php

namespace App\EventListener;

use App\Entity\User;
use App\Event\UserRegisterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class UserRegisterListener implements EventSubscriberInterface
{
    use LoggerAwareTrait;

    private $userManager;
    private $swift;
    private $templating;

    public function __construct(
        LoggerInterface $logger,
        Swift_Mailer  $serviceMail,
        Environment $templating
    )
    {
        $this->setLogger($logger);
        $this->swift = $serviceMail;
        $this->templating = $templating;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            "user.registred" => [
                ["onUserRegistred", 0],
                ["writeLog", -10],
            ]
        ];
    }

    public function onUserRegistred(UserRegisterEvent $event):void
    {
        $user = $event->getUser();
        if($user instanceof User)
        {
            $this->sendMail($user);
            $event->stopPropagation();
            $this->writeLog( $user);
        }
    }

    public function writeLog( User $user): void
    {
        $this->logger->info(sprintf("Un nouveau client s'est inscrit sur le site ! Bienvenue à %s" , $user->getUsername()));
    }

    private function sendMail( User $user) : void
    {
        $sendTo  = 'pierretisserand31@gmail.com';
        $message = (new Swift_Message('Nouveau client'))
            ->setFrom('no-reply@fyps.fr')
            ->setTo($sendTo)
            ->setBody(
                $this->templating->render(
                    'emails/UserRegistred.html.twig',
                    ['user' => $user]
                ),
                'text/html'
            );
        $this->swift->send($message);
    }
}
