<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CardController extends AbstractController
{
    public function createCard(ManagerRegistry $doctrine, Request $request): Response
    {
        $card = new Card();

        $form = $this->createForm(CardType::class, $card);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Card $card */
            $card = $form->getData();

            $repository = $doctrine->getRepository(Card::class);

            $exist = $repository->findOneBy([
                'title' => $card->getTitle()
            ]);

            if (!$exist) {
                $em = $doctrine->getManager();
                $em->persist($card);
                $em->flush();
            }
        }

        $cards = $doctrine->getRepository(Card::class)->findAll();

        return $this->render(
            'admin/card.html.twig',
            ['card' => $form, 'cards' => $cards]
        );
    }


    public function removeCard(ManagerRegistry $doctrine, int $id): RedirectResponse
    {

        $em = $doctrine->getManager();
        $card = $em->getRepository(Card::class)->find($id);

        if ($card) {
            $em->remove($card);
            $em->flush();
        }

        return $this->redirectToRoute('card');


    }

    public function editCard(ManagerRegistry $doctrine, Request $request, int $id)
    {
        $em = $doctrine->getManager();
        $card = $em->getRepository(Card::class)->find($id);

        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = $form->getData();
            $em->persist($card);
            $em->flush();

            return $this->redirectToRoute('card');
        }

        return $this->render('admin/editCard.html.twig', [
            'form' => $form->createView(),
        ]);
    }


/*    public function editCardForm(ManagerRegistry $doctrine, int $id, Request $request): Response
    {
        $em = $doctrine->getManager();
        $card = $em->getRepository(Card::class)->find($id);

        $form = $this->createForm(CardType::class, $card);

        return $this->render(
            'admin/editCard.html.twig',
            ['card' => $form, 'id' => $id]
        );
    }*/


    /*public function addTag(ManagerRegistry $doctrine, int $id, int $tagId): RedirectResponse
    {
        $em = $doctrine->getManager();
        $card = $em->getRepository(Card::class)->find($id);
        $tag = $em->getRepository(Tag::class)->find($tagId);

        $card->addTag($tag);
        $em->persist($card);
        $em->flush();

        return $this->redirectToRoute('card');
    }*/

}