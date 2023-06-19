<?php

namespace App\Controller;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class pagesController extends AbstractController
{
    public function getCategory(CategoryRepository $repository)
    {
        $categorys = $repository->findLatestPublished();
        return $categorys;
    }
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(CategoryRepository $repository)
    {
        return $this->render('pages/homepage.html.twig', [
            'categorys' => $this->getCategory($repository),
        ]);
    }
    /**
     * @Route("/{slug}", name="app_page")
     */
    public function pages($slug,
                          CategoryRepository $repository,
                          PaginatorInterface $paginator,
                          ProductsRepository $productsRepository,
                          Request $request,
    ){
        if($slug == 'contacts') {
            return $this->render('pages/contacts.html.twig', [
                'category' => ['name' => 'Контакты'],
                'categorys' => $this->getCategory($repository),
            ]);
        }
        if($slug == 'about') {
            return $this->render('pages/about.html.twig', [
                'category' => ['name' => 'О нас'],
                'categorys' => $this->getCategory($repository),

            ]);
        }
        if($slug == 'compare') {
            return $this->render('pages/compare.html.twig', [
                'category' => ['name' => 'СРАВНЕНИЕ ТОВАРОВ'],
                'categorys' => $this->getCategory($repository),
            ]);
        }
        if($slug == 'catalog') {

            $pagination = $paginator->paginate(
                $productsRepository->findAll(), /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                8 /*limit per page*/
            );
            //dd($pagination);

            return $this->render('catalog/catalog.html.twig', [
                'items' => $pagination,
                'category' => ['name' => 'Каталог'],
                'categorys' => $this->getCategory($repository),
            ]);
        }
    }
}
