<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuestBookController extends AbstractController
{
    #[Route('/', name: 'app_guest_book')]
    public function index(): Response
    {
        return $this->render('guest_book/index.html.twig', [
            'controller_name' => 'GuestBookController',
        ]);
    }
}
