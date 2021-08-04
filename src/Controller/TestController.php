<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Order;
use App\Traits\TestTrait;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    use TestTrait;

    /**
     * @Route ("/", name="index")
     */
    public function index()
    {
        $http = new Client();
        $response = $http->post('https://apptest.wearepentagon.com/devInterview/API/en/access-token', [
            'form_params' => [
                'client_id' => 'devtask',
                'client_secret' => 'Ye97T%c!CGZ*7$52',
            ],
        ]);

        $response = json_decode((string) $response->getBody(), true);
        $token = $response['access_token'];

        $response = $http->post('https://apptest.wearepentagon.com/devInterview/API/en/get-random-test-feed', [
            'headers' => [
                'Authorization' => $token,
            ],
        ]);

        $new = json_decode((string) $response->getBody(), true);
        $new2 = explode( ':', $new);
        $new3 = explode('||', $new2[1]);
        $items = [];

        foreach ($new3 as $item) {
            preg_match('/(.*?)\{(.*)\}.*/i', $item, $match);
            $items[$match[1]] = $match[2];
        }
        $test = '';
        $entityManager = $this->getDoctrine()->getManager();

        switch ($new2[0]) {
            case ($new2[0] == 'order'):
                $test = new Order();
                $test->setId($items['id']);
                $test->setTotal($items['total']);
                $test->setShippingTotal($items['shipping_total']);
                $test->setCreateTime($items['create_time']);
                $test->setTimezone($items['timezone']);
                break;
            case ($new2[0] == 'product'):
                $test = new Product();
                $test->setSKU($items['SKU']);
                $test->setTitle($items['title']);
                $test->setImage($items['image\base64;jpeg']);
                break;
            default:
                echo "Error";
                break;
        }
        $entityManager->persist($test);
        $entityManager->flush();

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