<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param $body
     * @param $entityManager
     * @return Product
     */
    public function productSave($body, $entityManager): Product
    {
        $test = new Product();
        $test->setId($body['id']);
        $test->setTotal($body['total']);
        $test->setShippingTotal($body['shipping_total']);
        $test->setCreateTime($body['create_time']);
        $test->setTimezone($body['timezone']);

        $entityManager->persist($test);
        $entityManager->flush();

        return $test;
    }
}
