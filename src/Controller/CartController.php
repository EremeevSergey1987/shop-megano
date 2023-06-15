<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    public function getCategory(CategoryRepository $repository)
    {
        $categorys = $repository->findLatestPublished();
        return $categorys;
    }
    public $items = [
        [
            'category' => 'Category name',
            'img' => 'assets/img/content/home/card.jpg',
            'desc' => 'Corsair Carbide Series Arctic White Steel 1',
            'price' => '85.00',
            'price_sale' => '75.00',
        ],
        [
            'category' => 'Category name',
            'img' => 'assets/img/content/home/card.jpg',
            'desc' => 'Corsair Carbide Series Arctic White Steel 2',
            'price' => '85.00',
            'price_sale' => '75.00',
        ],
        [
            'category' => 'Category name',
            'img' => 'assets/img/content/home/card.jpg',
            'desc' => 'Corsair Carbide Series Arctic White Steel 3',
            'price' => '85.00',
            'price_sale' => '75.00',
        ],
        [
            'category' => 'Category name',
            'img' => 'assets/img/content/home/card.jpg',
            'desc' => 'Corsair Carbide Series Arctic White Steel 4',
            'price' => '85.00',
            'price_sale' => '75.00',
        ],
    ];
    #[Route('/cart', name: 'app_cart')]
    public function index(CategoryRepository $repository): Response
    {
        return $this->render('cart/index.html.twig', [
            'items' => $this->items,
            'category' => ['name' => 'Корзина'],
            'categorys' => $this->getCategory($repository),
        ]);
    }
}
