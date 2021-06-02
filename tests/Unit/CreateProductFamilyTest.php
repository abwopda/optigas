<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Entity\TypeProduct;
use App\Entity\ProductFamily;
use App\UseCase\UseProductFamily;
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
        $useCase = new UseProductFamily(new ProductFamilyRepository());

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

        $this->AssertEquals($productfamily, $useCase->create($productfamily));
    }
    /**
     * @dataProvider provideBadProductFamily
     * @param ProductFamily $productfamily
     */
    public function testBadProductFamily(ProductFamily $productfamily)
    {
        $useCase = new UseProductFamily(new ProductFamilyRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($productfamily, $useCase->create($productfamily));
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
