<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Wish;
use App\Form\WishType;
use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security
    ){}

    #[Route('/wish', name: 'app_wish')]
    public function index(): Response
    {
        return $this->render('wish/index.html.twig', [
            'controller_name' => 'WishController',
        ]);
    }

    #[Route('/wish/create', name: 'wish_create')]
    public function create(Request $request): Response
    {
        $wish = new Wish();
        $wish->setIsModerated(false);
        $wish->setCreatedAt(CarbonImmutable::now());
        /**
         * @var User $user
         */
        if ($user = $this->security->getUser()) {
            $wish->setUserName($user->getUserName());
            $wish->setEmail($user->getEmail());
            $wish->setUser($user);
        }

        $form = $this->createForm(WishType::class, $wish);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($wish);
            $this->entityManager->flush();

            return $this->redirectToRoute('guest_book_index');
        }

        return $this->render('wish/create.html.twig', [
            'wish_form' => $form,
        ]);
    }
}
