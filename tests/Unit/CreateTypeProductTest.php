<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Entity\TypeProduct;
use App\UseCase\UseTypeProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateTypeProductTest
 * @package App\Tests\Unit
 */
class CreateTypeProductTest extends TestCase
{
    public function testSuccessfulTypeProductCreated()
    {
        $useCase = new UseTypeProduct(new TypeProductRepository());

        $typeproduct = (new TypeProduct())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        $this->AssertEquals($typeproduct, $useCase->create($typeproduct));
    }
    /**
     * @dataProvider provideBadTypeProduct
     * @param TypeProduct $typeproduct
     */
    public function testBadTypeProduct(TypeProduct $typeproduct)
    {
        $useCase = new UseTypeProduct(new TypeProductRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($typeproduct, $useCase->create($typeproduct));
    }

    /**
     * @return \Generator
     */
    public function provideBadTypeProduct(): \Generator
    {
        yield[
            (new TypeProduct())
                ->setName("name")
                ->setDescription("description")
        ];
        yield[
            (new TypeProduct())
                ->setCode("")
                ->setName("name")
                ->setDescription("description")
        ];
        yield[
            (new TypeProduct())
                ->setCode("code")
                ->setDescription("description")
        ];
        yield[
            (new TypeProduct())
                ->setCode("code")
                ->setName("")
        ];
        yield[
            (new TypeProduct())
                ->setCode("code")
                ->setName("name")
                ->setDescription("")
        ];
    }
}
