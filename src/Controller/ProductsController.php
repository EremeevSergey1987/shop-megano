<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Products;
use Symfony\Component\HttpFoundation\Request;


class ProductsController extends pagesController
{
    #[Route('/category/{slug}/{item}', name: 'app_products')]

    public function index(Request $request,
                          $slug,
                          $item,
                          EntityManagerInterface $em,
                          CategoryRepository $repository)
    {
        $product = $em->getRepository(Products::class)->findOneBy(['slug' => $item]);



        return $this->render('products/index.html.twig', [
            'category' => $product,
            'categorys' => $this->getCategory($repository),
        ]);
    }
}
