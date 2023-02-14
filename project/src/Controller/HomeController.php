<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\MailerType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends AbstractController
{
    public function home(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();

        $cards = $em->getRepository(Card::class);
        $cards = $cards->findBy([], ['id' => 'DESC'], 3);
        $tagsByCard = $em->getRepository(Card::class)->getTagsByCard($cards);

        $form = $this->createForm(MailerType::class);

        return $this->render('home/home.html.twig',
            ['tags' => $tagsByCard, 'cards' => $cards, 'mail' => $form]
        );
    }

}