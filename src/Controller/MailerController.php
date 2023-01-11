<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function sendMail(MailerInterface $mailer): Response
    {
        $from = 'tisch1@menukarte.wip';
        $to = 'to@menukarte.wip';

        $subject = 'Time for Symfony Mailer!';
        $text = 'Bitte mit Rot und Weiß';

        $template = 'mailer/mail.html.twig';

        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text($text)
            ->htmlTemplate($template)
            ->context([
                'from' => $from,
                'to' => $to,
                'subject' => $subject,
                'text' => $text,
            ]);

        $mailer->send($email);

        return new Response('email versendet');
    }
}
