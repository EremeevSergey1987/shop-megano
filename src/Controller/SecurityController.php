<?php
namespace App\Controller;

use App\Form\UserRegistrationFormType;
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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Util\TargetPathTrait;


class SecurityController extends AbstractController
{
    use TargetPathTrait;

    private EntityManagerInterface $entityManager;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator,)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
    }


    public function getCategory(CategoryRepository $repository)
    {
        $categorys = $repository->findLatestPublished();
        return $categorys;
    }
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, CategoryRepository $repository): Response
    {
        //dd($this->redirectToRoute());
//         if ($this->getUser()) {
//             return $this->redirectToRoute('target_path');
//         }

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
    public function register(
        Request $request,
        CategoryRepository $repository,
        UserPasswordHasherInterface $passwordHasher,
        Security $security,
    )

    {
        $form = $this->createForm(UserRegistrationFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            /** @var User $user */
            $user = $form->getData();
            $user
                ->setPassword($passwordHasher->hashPassword($user, $user->getPassword()))
                ->setRoles(['ROLE_USER']);
            $this->entityManager->persist($user);
            $security->login($user, LoginFormAuthenticator::class);
            $this->entityManager->flush();
            return new RedirectResponse('/cart');
        }


        return $this->render('pages/register.html.twig', [
            'category' => ['name' => 'Регистрация'],
            'categorys' => $this->getCategory($repository),
            'registrationForm' => $form->createView(),
            'error' => '',
        ]);
    }



    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
