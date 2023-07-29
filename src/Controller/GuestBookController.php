<?php

namespace App\Controller;

use App\Repository\WishRepository;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuestBookController extends AbstractController
{
    #[Route('/', name: 'guest_book_index')]
    public function index(
        Request $request,
        WishRepository $wishRepository,
        PaginationService $paginationService
    ): Response {
        $page = $request->query->getInt('page', 1);

        $wishes = $wishRepository->getWishPaginator($page);

        $pagination = $paginationService->getPaginationData($wishes, $page, WishRepository::ITEMS_PER_PAGE);

        return $this->render('guest_book/index.html.twig', [
            'wishes' => $wishes,
            'pagination' => $pagination,
        ]);
    }
}
