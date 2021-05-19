<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Entity\TypeProduct;
use App\Entity\ProductFamily;
use App\UseCase\CreateProductFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateProductFamilyTest
 * @package App\Tests\Unit
 */
class CreateProductFamilyTest extends TestCase
{
    public function testSuccessfulProductFamilyCreated()
    {
        $useCase = new CreateProductFamily(new ProductFamilyRepository());

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

        $this->AssertEquals($productfamily, $useCase->execute($productfamily));
    }
    /**
     * @dataProvider provideBadProductFamily
     * @param ProductFamily $productfamily
     */
    public function testBadProductFamily(ProductFamily $productfamily)
    {
        $useCase = new CreateProductFamily(new ProductFamilyRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($productfamily, $useCase->execute($productfamily));
    }

    /**
     * @return \Generator
     */
    public function provideBadProductFamily(): \Generator
    {
        $typeproduct = (new TypeProduct())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        yield [
            (new ProductFamily($typeproduct))
                ->setName("name")
                ->setDescription("description")
        ];
        yield [
            (new ProductFamily($typeproduct))
                ->setCode("")
                ->setName("name")
                ->setDescription("description")
        ];
        yield [
            (new ProductFamily($typeproduct))
                ->setName("name")
                ->setDescription("description")
        ];
        yield [
            (new ProductFamily($typeproduct))
                ->setCode("code")
                ->setName("")
                ->setDescription("description")
        ];
        yield [
            (new ProductFamily($typeproduct))
                ->setCode("code")
                ->setName("name")
        ];
        yield [
            (new ProductFamily($typeproduct))
                ->setName("code")
                ->setName("name")
                ->setDescription("")
        ];
    }
}
