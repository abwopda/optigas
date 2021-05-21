<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\Product;
use App\UseCase\ActivateProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivateProductTest
 * @package App\Tests\Unit
 */
class ActivateProductTest extends TestCase
{
    public function testSuccessfulProductActivated()
    {
        $useCase = new activateProduct(new ProductRepository());
        for ($i = 1; $i <= 9; $i++) {
            $entity = (new ProductRepository())->findOneById($i);

            $this->assertInstanceOf(Product::class, $useCase->execute($entity, true));

            $this->assertInstanceOf(Product::class, $useCase->execute($entity, false));
        }
    }
}
