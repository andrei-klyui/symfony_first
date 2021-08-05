<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        $test->setSKU($body['SKU']);
        $test->setTitle($body['title']);
        $test->setImage($body['image\base64;jpeg']);

        try {
            $entityManager->persist($test);
            $entityManager->flush();
        } catch (\Exception $e) {
            throw new HttpException(400, "Error while saving the object!");
        }

        return $test;
    }
}
