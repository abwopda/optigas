<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\Product;
use App\UseCase\UseProduct;
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
        $useCase = new UseProduct(new ProductRepository());
        for ($i = 9; $i <= 9; $i++) {
            $entity = (new ProductRepository())->findOneById($i);

            $this->assertInstanceOf(Product::class, $useCase->validate($entity, true));

            $this->assertInstanceOf(Product::class, $useCase->validate($entity, false));
        }
    }
}
