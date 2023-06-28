<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @IsGranted("ROLE_USER")
 */

class AccountController extends pagesController
{
    #[Route('/account', name: 'app_account')]
    public function index(
        CategoryRepository $repository,
        UserRepository $userRepository,
        Request $request
    ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        //dd($user);

        return $this->render('account/index.html.twig', [
            'categorys' => $this->getCategory($repository),
            'user' => $user,
            'category' => ['name' => 'Профиль'],

        ]);
    }
}
