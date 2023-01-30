<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    function home()
    {
        return $this->render(
            'admin/admin.html.twig',
            ['auth'=> false]
        );
    }

}