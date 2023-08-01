<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use App\Service\FileUploaderService;
use App\Service\PaginationService;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class WishController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security,
        private FileUploaderService $uploaderService
    ){}

    #[Route('/')]
    public function indexNoLocale(): RedirectResponse
    {
        return $this->redirectToRoute('wish_index', ['_locale' => 'en']);
    }

    #[Route('/{_locale<%app.supported_locales%>}/', name: 'wish_index')]
    public function index(
        Request $request,
        WishRepository $wishRepository,
        PaginationService $paginationService
    ): Response {
        $page = $request->query->getInt('page', 1);
        /**
         * @var User $user
         */
        $user = $this->security->getUser();

        $wishes = $wishRepository->getWishPaginator($page, $user?->getId());

        $pagination = $paginationService->getPaginationData($wishes, $page, WishRepository::ITEMS_PER_PAGE);

        return $this->render('wish/index.html.twig', [
            'wishes' => $wishes,
            'pagination' => $pagination,
        ]);
    }

    #[Route('/{_locale<%app.supported_locales%>}/wish/create', name: 'wish_create')]
    public function create(Request $request): Response
    {
        $wish = new Wish();
        $wish->setIsModerated(false);
        $wish->setCreatedAt(Carbon::now());
        /**
         * @var User $user
         */
        if ($user = $this->security->getUser()) {
            $wish->setUserName($user->getUserName());
            $wish->setEmail($user->getEmail());
            $wish->setUser($user);
        }

        return $this->processForm($request, $wish);
    }

    #[Route('/{_locale<%app.supported_locales%>}/wish/update/{id}', name: 'wish_update')]
    #[IsGranted('delete', 'wish')]
    public function update(Request $request, Wish $wish): Response
    {
        return $this->processForm($request, $wish);
    }

    #[Route('/{_locale<%app.supported_locales%>}/wish/delete/{id}', name: 'wish_delete')]
    #[IsGranted('delete', 'wish')]
    public function delete(Wish $wish): RedirectResponse
    {
        $this->entityManager->remove($wish);
        $this->entityManager->flush();

        return $this->redirectToRoute('wish_index');
    }

    private function processForm(Request $request, Wish $wish): Response|RedirectResponse
    {
        $form = $this->createForm(WishType::class, $wish);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $imageFile
             */
            if ($imageFile = $form->get('imageFile')->getData()) {
                $targetDirectory = $this->getParameter('image_directory');
                $imageFileName = $this->uploaderService->upload($imageFile, $targetDirectory);
                $wish->setImageFile($imageFileName);
            }

            $this->entityManager->persist($wish);
            $this->entityManager->flush();

            return $this->redirectToRoute('wish_index');
        }

        return $this->render('wish/create.html.twig', [
            'wish_form' => $form,
        ]);
    }
}
