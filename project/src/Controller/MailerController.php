<?php

namespace App\Controller;

use App\Form\MailerType;
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

        $form = $this->createForm(MailerType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mail = $form->getData();
            $email = (new TemplatedEmail())
                //->from('hello@example.com')
                ->from($mail['email'])
                ->to('jay.cormier@icloud.com')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('john.doe@example.com')
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Site vitrine - ' . $mail['email'])
                //->text('Bonsoir, voici le texte du mail')
                //->html($mail['text'])
                ->htmlTemplate('mail.html.twig')
                ->context([
                    'mail' => $mail['email'],
                    'text' => $mail['text'],
                ]);

            $mailer->send($email);

        }

            $this->addFlash('success', 'Votre message a bien été envoyé');

        return $this->redirect('/');

    }
}