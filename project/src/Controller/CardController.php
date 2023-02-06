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

                $cards = $doctrine->getRepository(Card::class)->findAll();

                return $this->render(
                    'admin/card.html.twig',
                    ['card' => $form, 'cards' => $cards]
                );
            }

            $cards = $doctrine->getRepository(Card::class)->findAll();

            return $this->render(
                'admin/card.html.twig',
                ['card' => $form, 'cards' => $cards]
            );
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

    /*public function editCard(int $id, Request $request, ManagerRegistry $doctrine)
    {


        $data = $request->request->all();
        $em = $doctrine->getManager();
        $card = $em->getRepository(Card::class)->find($id);

        if (!array_key_exists('title', $data)) {
            return $this->redirectToRoute('edit_card', ['id' => $id]);
        }

        $card->setTitle($data['title']);
        $em->flush();

        return $this->redirectToRoute('edit_card', ['id' => $id]);


        /*$em = $doctrine->getManager();
        $card = $em->getRepository(Card::class)->find($id);

        $form = $this->createForm(CardType::class, $card);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('card');
        }

        return $this->redirectToRoute('editCard', ['id' => $id]);

}*/


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


    public function editCardForm(ManagerRegistry $doctrine, int $id, Request $request): Response
    {
        $em = $doctrine->getManager();
        $card = $em->getRepository(Card::class)->find($id);

        $form = $this->createForm(CardType::class, $card);

        return $this->render(
            'admin/editCard.html.twig',
            ['card' => $form, 'id' => $id]
        );
    }
}