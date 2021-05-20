<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\Product;
use App\UseCase\ValidateProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidateProductTest
 * @package App\Tests\Unit
 */
class ValidateProductTest extends TestCase
{
    public function testSuccessfulProductValidated()
    {
        $useCase = new validateProduct(new ProductRepository());
        for ($i = 1; $i <= 9; $i++) {
            $entity = (new ProductRepository())->findOneById($i);

            $this->assertInstanceOf(Product::class, $useCase->execute($entity, 1));

            $this->assertInstanceOf(Product::class, $useCase->execute($entity, 0));
        }
    }
}
