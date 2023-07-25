<?php

namespace App\Controller;

use App\Form\AccountEditFormType;
use App\Repository\CategoryRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
        FileUploader $UserFileUploader,
    ): Response
    {
        $form = $this->createForm(AccountEditFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $formData = $form->getData();
            $user = $em->getRepository(User::class)->find($this->getUser()->getId());

            if (!$user) {
                throw $this->createNotFoundException(
                    'No user found for id ' . $this->getUser()->getId()
                );
            }
            $user->setFirstName($formData->getFirstName());
            /** @var UploadedFile|null $image */
            $image = $form['imageFilename']->getData();
            if($image)
            {
                $user->setImageFilename($UserFileUploader->uploadFile($image));
            }
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
