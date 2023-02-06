<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AuthenticationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AdminController extends AbstractController
{
    public function home(ManagerRegistry $doctrine, Request $request): Response
    {
        $admin = new Admin();

        $form = $this->createForm(AuthenticationType::class, $admin);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Admin $admin */
            $admin = $form->getData();

            $repository = $doctrine->getRepository(Admin::class);

            $user = $repository->findOneBy([
                'email' => $admin->getEmail(),
                'password' => $admin->getPassword()
            ]);

            if ($user) {
                return $this->render(
                    'admin/backoffice.html.twig'
                );
            }

            return $this->render(
                'admin/admin.html.twig',
                ['auth' => $form]
            );
        }

        return $this->render(
            'admin/admin.html.twig',
            ['auth' => $form]
        );
    }

}