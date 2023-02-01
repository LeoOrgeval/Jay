<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

class AuthController
{
    function login(Request $request): void
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        dd($request);
    }
}