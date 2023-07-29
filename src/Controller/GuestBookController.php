<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuestBookController extends AbstractController
{
    #[Route('/', name: 'guest_book_index')]
    public function index(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy(['isModerated' => true], ['createdAt' => 'DESC']);

        return $this->render('guest_book/index.html.twig', [
            'wishes' => $wishes,
        ]);
    }
}
