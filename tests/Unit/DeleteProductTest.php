<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\Product;
use App\UseCase\UseProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteProductTest
 * @package App\Tests\Unit
 */
class DeleteProductTest extends TestCase
{
    public function testSuccessfulProductDeleted()
    {
        $useCase = new UseProduct(new ProductRepository());
        for ($i = 9; $i <= 9; $i++) {
            $entity = (new ProductRepository())->findOneById($i);

            $this->assertNull($useCase->delete($entity));
        }
    }
}
