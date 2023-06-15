<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Entity\User;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCategory(CategoryRepository $repository)
    {
        $categorys = $repository->findLatestPublished();
        return $categorys;
    }
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, CategoryRepository $repository): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'category' => ['name' => 'Вход'],
            'categorys' => $this->getCategory($repository),

            'error' => $error]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(\Symfony\Component\HttpFoundation\Request $request,
                             CategoryRepository $repository,
                             UserPasswordHasherInterface $passwordHasher,
                             LoginFormAuthenticator $authenticator
    )
    {
        if($request->isMethod('POST')){
            $user = new User();
            $user
                ->setEmail($request->request->get('email'))
                ->setFirstName($request->request->get('first_name'))
                ->setPassword($request->request->get('password'));

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $authenticator->authenticate($request);


            return new RedirectResponse('/');
        }
        return $this->render('pages/register.html.twig', [
            'category' => ['name' => 'Регистрация'],
            'categorys' => $this->getCategory($repository),
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
