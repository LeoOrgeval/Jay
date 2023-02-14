<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
class MailerController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/email')]
    public function sendEmail(MailerInterface $mailer, Request $request): Response
    {


        $email = (new TemplatedEmail())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('john.doe@example.com')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Voici le sujet')
            ->text('Bonsoir, voici le texte du mail')
            ->htmlTemplate('home/testmail.html.twig')
            ->context([
                'firstname' => 'Joe'
            ]);

        $mailer->send($email);

        $this->addFlash('success', 'Votre message a bien été envoyé');

        return $this->redirectToRoute('home');

    }
}