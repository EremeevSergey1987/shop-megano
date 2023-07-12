<?php

namespace App\Controller;

use App\Form\AccountEditFormType;
use App\Repository\CategoryRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserRegistrationFormType;
use App\Entity\User;
/**
 * @IsGranted("ROLE_USER")
 */
class AccountEditController extends pagesController
{
    #[Route('/account/edit', name: 'app_account_edit')]
    public function index(
        CategoryRepository $repository,
        EntityManagerInterface $em,
        Request $request,
    ): Response
    {
        $form = $this->createForm(AccountEditFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /** @var User $user */
            // $user2 - это - то что мы вписали в форму
            $formData = $form->getData();
            $id = $this->getUser()->getId();
            // $user - это - то что он запросил из базы данных
            $user = $em->getRepository(User::class)->find($id);

            if (!$user) {
                throw $this->createNotFoundException(
                    'No user found for id ' . $id
                );
            }

            $user
                ->setFirstName($formData->getFirstName())
                ->setEmail($this->getUser()->getEmail())
            ;

            $em->flush();
            $this->addFlash('flash_message', 'Данные поменял');

            return $this->redirectToRoute('app_account', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('account_edit/index.html.twig', [
            'categorys' => $this->getCategory($repository),
            'controller_name' => 'test',
            'EditUserForm' => $form->createView(),
            'category' => ['name' => 'Редактирование личных данных'],
        ]);
    }
}
