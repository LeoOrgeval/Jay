<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Tag;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends AbstractController
{
    public function getCardsTags(ManagerRegistry $doctrine): Response
    {
        $cards = $doctrine->getRepository(Card::class)->findAll();
        $tags = $doctrine->getRepository(Tag::class)->findAll();

        return $this->render(
            'projects/projects.html.twig',
            ['tags' => $tags, 'cards' => $cards]
        );
    }

    public function getFilter(ManagerRegistry $doctrine, int $id): Response
    {
        $em = $doctrine->getManager();
        $tags = $doctrine->getRepository(Tag::class)->findAll();
        $tag = $em->getRepository(Tag::class)->find($id);
        $cards = $em->getRepository(Tag::class)->getCardsByTag($id);

        return $this->render(
            'projects/projectsfilter.html.twig',
            ['tags' => $tags, 'tag' => $tag, 'cards' => $cards]
        );
    }
}
