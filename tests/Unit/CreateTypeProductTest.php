<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Entity\TypeProduct;
use App\UseCase\CreateTypeProduct;
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
        $useCase = new CreateTypeProduct(new TypeProductRepository());

        $typeproduct = (new TypeProduct())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
        ;

        $this->AssertEquals($typeproduct, $useCase->execute($typeproduct));
    }
    /**
     * @dataProvider provideBadTypeProduct
     * @param TypeProduct $typeproduct
     */
    public function testBadTypeProduct(TypeProduct $typeproduct)
    {
        $useCase = new CreateTypeProduct(new TypeProductRepository());

        $this->expectException(LazyAssertionException::class);

        $this->assertEquals($typeproduct, $useCase->execute($typeproduct));
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
