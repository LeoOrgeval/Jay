<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

class AuthController
{
    function login(Request $request): void
    {
        dd($request);
    }
}