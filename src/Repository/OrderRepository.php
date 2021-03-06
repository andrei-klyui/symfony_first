<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @param $body
     * @param $entityManager
     * @return Order
     */
    public function orderSave($body, $entityManager): Order
    {
        $test = new Order();
        $test->setId($body['id']);
        $test->setTotal($body['total']);
        $test->setShippingTotal($body['shipping_total']);
        $test->setCreateTime($body['create_time']);
        $test->setTimezone($body['timezone']);

        try {
            $entityManager->persist($test);
            $entityManager->flush();
        } catch (\Throwable $e) {
            throw new HttpException(400, "Error while saving the object!");
        }

        return $test;
    }
}
