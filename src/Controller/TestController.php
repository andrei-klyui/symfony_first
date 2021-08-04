<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Order;
use App\Traits\TestTrait;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    use TestTrait;

    protected $orderRepository;
    protected $productRepository;

    public function __construct(
        OrderRepository $orderRepository,
        ProductRepository $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route ("/", name="index")
     * @param $items
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        $token = $this->loginToApi();
        [$typeProduct, $body] = $this->decodeGetPars($token);

        $entityManager = $this->getDoctrine()->getManager();

        switch ($typeProduct) {
            case ($typeProduct == 'order'):
                $this->orderRepository->orderSave($body, $entityManager);
                break;
            case ($typeProduct == 'product'):
                $this->productRepository->productSave($body, $entityManager);
                break;
            default:
                echo "Error";
                break;
        }

        $products = $this->getDoctrine()
            ->getRepository(Product::class);
        $orders = $this->getDoctrine()
            ->getRepository(Order::class);

        return $this->render('test/index.html.twig', [
            'products' => $products->findAll(),
            'orders' => $orders->findAll()
        ]);
    }
}