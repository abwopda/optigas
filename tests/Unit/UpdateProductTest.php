<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\Product;
use App\UseCase\UpdateProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateProductTest
 * @package App\Tests\Unit
 */
class UpdateProductTest extends TestCase
{
    public function testSuccessfulProductUpdated()
    {
        $useCase = new updateProduct(new ProductRepository());

        for ($i = 1; $i <= 9; $i++) {
            $entity = (new ProductRepository())
                ->findOneById($i)
                ->setName("PROD0" . $i)
            ;
            $this->assertInstanceOf(Product::class, $useCase->execute($entity));
        }
    }
}
