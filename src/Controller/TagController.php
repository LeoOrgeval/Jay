<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

                $tags = $doctrine->getRepository(Tag::class)->findAll();

                return $this->render(
                    'admin/tag.html.twig',
                    ['tag' => $form, 'tags' => $tags]
                );
            }

            $tags = $doctrine->getRepository(Tag::class)->findAll();

            //Il faut que je retourne une erreur comme quoi il existe déjà
            return $this->render(
                'admin/tag.html.twig',
                ['tag' => $form, 'tags' => $tags]
            );
        }
        $tags = $doctrine->getRepository(Tag::class)->findAll();

        return $this->render(
            'admin/tag.html.twig',
            ['tag' => $form, 'tags' => $tags]


        );
    }

    public function removeTag(ManagerRegistry $doctrine, int $id): RedirectResponse
    {
        $em = $doctrine->getManager();
        $tag = $em->getRepository(Tag::class)->find($id);

        if($tag) {
            $em->remove($tag);
            $em->flush();
        }
        return $this->redirectToRoute('tag');

    }
    public function editTag(ManagerRegistry $doctrine, int $id): RedirectResponse
    {
        $em = $doctrine->getManager();
        $tag = $em->getRepository(Tag::class)->find($id);

        if($tag) {
            $em->remove($tag);
            $em->flush();
        }
        return $this->redirectToRoute('tag');

    }

}