<?php

namespace App\Application\Notification;


use Twig\Environment;

/**
 * Class NotSeenNotification
 * @package App\Application\Notification
 */
class NotSeenNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $renderer;

    /**
     * ContactNotification constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $renderer
     */
    public function __construct(
        \Swift_Mailer $mailer,
        Environment $renderer
    ) {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }


    /**
     * @param array $allFavorites
     * @param $user
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendNotSeenEpisode(array $allFavorites, $user)
    {
        $message = (new \Swift_Message('Reste à voir:'))
            ->setFrom('noreply@actu.fr')
            ->setTo('contact@actu.fr')
            ->setReplyTo($user->getEmail())
            ->setBody($this->renderer->render('email/episodesSeen.html.twig', [
                'allFavorites' => $allFavorites,
                'user' => $user
            ]), 'text/html');
        $this->mailer->send($message);
    }
}