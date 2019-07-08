<?php

namespace App\EventListener;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\TaskCreatedEvent;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class TaskCreatedListener implements EventSubscriberInterface
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
            "task.created" => [
                ["onTaskCreated", 0],
                ["writeLog", -10],
            ]
        ];
    }

    public function onTaskCreated(TaskCreatedEvent $event):void
    {
        $task = $event->getTask();
        $user = $event->getUser();
        if($task instanceof Task && $user instanceof User)
        {
            $this->sendMail($task, $user);
            $event->stopPropagation();
            $this->writeLog($task, $user);
        }
    }

    public function writeLog(Task $task, User $user): void
    {
        $this->logger->info(sprintf('New Task : %s , created by %s , and send mail', $task->getName(), $user->getUsername()));
    }

    private function sendMail(Task $task, User $user) : void
    {
        $sendTo  = 'ddoussain@gmail.com';
        $message = (new Swift_Message('[ojbento.fr] : Creation'))
            ->setFrom('no-reply@fyps.fr')
            ->setTo($sendTo)
            ->setBody(
                $this->templating->render(
                    'emails/task_creation.email.twig',
                    ['user' => $user, 'task' => $task]
                ),
                'text/html'
            );
        $this->swift->send($message);
    }
}
