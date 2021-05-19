<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Adapter\InMemory\Repository\ProductRepository;
use App\Entity\ProductFamily;
use App\Entity\Product;
use App\Entity\TypeProduct;
use App\UseCase\CreateProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateProductTest
 * @package App\Tests\Unit
 */
class CreateProductTest extends TestCase
{
    public function testSuccessfulProductCreated()
    {
        $useCase = new CreateProduct(new ProductRepository());

        $typeproduct = (new TypeProduct())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        $productfamily = (new ProductFamily($typeproduct))
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        $product = (new Product($productfamily))
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        $this->AssertEquals($product, $useCase->execute($product));
    }
    /**
     * @dataProvider provideBadProduct
     * @param Product $product
     */
    public function testBadProduct(Product $product)
    {
        $useCase = new CreateProduct(new ProductRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($product, $useCase->execute($product));
    }

    /**
     * @return \Generator
     */
    public function provideBadProduct(): \Generator
    {
        $typeproduct = (new TypeProduct())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        $productfamily = (new ProductFamily($typeproduct))
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        yield [
            (new Product($productfamily))
                ->setName("name")
                ->setDescription("description")
        ];
        yield [
            (new Product($productfamily))
                ->setCode("")
                ->setName("name")
                ->setDescription("description")
        ];
        yield [
            (new Product($productfamily))
                ->setName("name")
                ->setDescription("description")
        ];
        yield [
            (new Product($productfamily))
                ->setCode("code")
                ->setName("")
                ->setDescription("description")
        ];
        yield [
            (new Product($productfamily))
                ->setCode("code")
                ->setName("name")
        ];
        yield [
            (new Product($productfamily))
                ->setName("code")
                ->setName("name")
                ->setDescription("")
        ];
    }
}
