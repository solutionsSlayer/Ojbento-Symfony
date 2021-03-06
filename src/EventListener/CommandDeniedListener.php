<?php


namespace App\EventListener;

use App\Entity\Command;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\StateCommandEvent;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class CommandDeniedListener implements EventSubscriberInterface
{
    use LoggerAwareTrait;

    private $userManager;
    private $swift;
    private $templating;

    public function __construct(
        LoggerInterface $logger,
        Swift_Mailer $serviceMail,
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
            "command.denied" => [
                ["onCommandDenied", 0],
                ["writeLog", -10],
            ]
        ];
    }

    public function onCommandDenied(StateCommandEvent $event): void
    {

        $user = $event->getUser();
        if ($user instanceof User) {
            $this->sendMail($user);
            $event->stopPropagation();
            $this->writeLog($user);
        }
    }

    public function writeLog(User $user): void
    {
        $this->logger->info(sprintf('New command :  created by %s , and send mail',$user->getUsername()));
    }

    private function sendMail(User $user): void
    {
        $sendTo = 'ddoussain@gmail.com';
        $message = (new Swift_Message('[ojbento.fr] : Commande refusée'))
            ->setFrom('no-reply@ojbento.fr')
            ->setTo($sendTo)
            ->setBody(
                $this->templating->render(
                    'emails/denied_command.email.twig',
                    ['user' => $user]
                ),
                'text/html'
            );
        $this->swift->send($message);
    }
}
