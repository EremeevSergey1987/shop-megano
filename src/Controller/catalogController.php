<?php

namespace App\Controller;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class catalogController extends pagesController
{
    /**
     * @Route("/category/{slug}")
     */
    public function show(Request $request, $slug,
                         EntityManagerInterface $em,
                         CategoryRepository $repository,
                         ProductsRepository $productsRepository,
                         PaginatorInterface $paginator
    )
    {

        $category = $em->getRepository(Category::class)->findOneBy(['slug' => $slug]);

        $pagination = $paginator->paginate(
            $productsRepository->findAllWithSearchQuery(['category' => $category]), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            8 /*limit per page*/
        );



        return $this->render('/category/show.html.twig', [
            'category' => $category,
            'categorys' => $this->getCategory($repository),
            'products' => $pagination,
        ]);
    }
}