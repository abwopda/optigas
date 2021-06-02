<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\Product;
use App\UseCase\UseProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ShowProductTest
 * @package App\Tests\Unit
 */
class ShowProductTest extends TestCase
{
    public function testSuccessfulProductShowed()
    {
        $useCase = new UseProduct(new ProductRepository());

        for ($i = 9; $i <= 9; $i++) {
            $entity = (new ProductRepository())->findOneById($i);
            $this->assertInstanceOf(Product::class, $useCase->show($entity));
        }
    }

    /**
     * @dataProvider provideBadProduct
     * @param Product|null $product
     */
    public function testBadProduct(?Product $product)
    {
        $useCase = new UseProduct(new ProductRepository());

        $this->assertNull($useCase->show($product));
    }

    /**
     * @return \Generator
     */
    public function provideBadProduct(): \Generator
    {
        yield [
            (new ProductRepository())->findOneById(20)
        ];
    }
}
