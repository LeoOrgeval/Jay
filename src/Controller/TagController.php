<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    public function createTag(ManagerRegistry $doctrine, Request $request): Response
    {
        $tag = new Tag();

        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Tag $tag */
            $tag = $form->getData();

            $repository = $doctrine->getRepository(Tag::class);

            $exist = $repository->findOneBy([
                'title' => $tag->getTitle()
            ]);

            if (!$exist) {

                //Il faut que je le mette dans la base
                $em = $doctrine->getManager();
                $em->persist($tag);
                $em->flush();

                return $this->render(
                    'admin/backoffice.html.twig',
                    ['tag' => $form]
                );
            }

            dd('Le tag existe déjà');
            //Il faut que je retourne une erreur comme quoi il existe déjà
            return $this->render(
                'admin/backoffice.html.twig',
                ['tag' => $form]
            );
        }
        return $this->render(
            'admin/backoffice.html.twig',
            ['tag' => $form]
        );
    }

    public function deleteTag(ManagerRegistry $doctrine, Request $request): void
    {

    }

}