<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */

class AccountController extends pagesController
{
    #[Route('/account', name: 'app_account')]
    public function index(CategoryRepository $repository): Response
    {
        return $this->render('account/index.html.twig', [
            'categorys' => $this->getCategory($repository),
            'category' => ['name' => 'Профиль'],
        ]);
    }
}
