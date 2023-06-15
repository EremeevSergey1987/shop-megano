<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaleController extends pagesController
{
    #[Route('/sale', name: 'app_sale')]

    public function index(CategoryRepository $repository): Response
    {
        $sale_item = [
            [
                'image' => 'image.jpg',
                'createdAt' => new \DateTime('-11 days'),
                'name' => 'Basic Time Management Advanced Course',
                'description' => 'LOREM IPSUM DOLOR SIT AMET CONSECTETUER ADIPISCING ELIT SED DIAM NONUMMY NIBH EUISMOD TINCID UNT UT LAOREET DOLORE',
            ],
            [
                'image' => 'image.jpg',
                'createdAt' => new \DateTime('-11 days'),
                'name' => 'Basic Time Management Advanced Course',
                'description' => 'LOREM IPSUM DOLOR SIT AMET CONSECTETUER ADIPISCING ELIT SED DIAM NONUMMY NIBH EUISMOD TINCID UNT UT LAOREET DOLORE',
            ],
            [
                'image' => 'image.jpg',
                'createdAt' => new \DateTime('-11 days'),
                'name' => 'Basic Time Management Advanced Course',
                'description' => 'LOREM IPSUM DOLOR SIT AMET CONSECTETUER ADIPISCING ELIT SED DIAM NONUMMY NIBH EUISMOD TINCID UNT UT LAOREET DOLORE',
            ],            [
                'image' => 'image.jpg',
                'createdAt' => new \DateTime('-11 days'),
                'name' => 'Basic Time Management Advanced Course',
                'description' => 'LOREM IPSUM DOLOR SIT AMET CONSECTETUER ADIPISCING ELIT SED DIAM NONUMMY NIBH EUISMOD TINCID UNT UT LAOREET DOLORE',
            ],            [
                'image' => 'image.jpg',
                'createdAt' => new \DateTime('-11 days'),
                'name' => 'Basic Time Management Advanced Course',
                'description' => 'LOREM IPSUM DOLOR SIT AMET CONSECTETUER ADIPISCING ELIT SED DIAM NONUMMY NIBH EUISMOD TINCID UNT UT LAOREET DOLORE',
            ],            [
                'image' => 'image.jpg',
                'createdAt' => new \DateTime('-11 days'),
                'name' => 'Basic Time Management Advanced Course',
                'description' => 'LOREM IPSUM DOLOR SIT AMET CONSECTETUER ADIPISCING ELIT SED DIAM NONUMMY NIBH EUISMOD TINCID UNT UT LAOREET DOLORE',
            ],
        ];

        return $this->render('sale/index.html.twig', [
            'controller_name' => 'SaleController',
            'sale_item' => $sale_item,
            'category' => ['name' => 'Скидки'],
            'categorys' => $this->getCategory($repository),
        ]);
    }
}
