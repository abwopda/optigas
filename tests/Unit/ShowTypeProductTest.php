<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Entity\TypeProduct;
use App\UseCase\ShowTypeProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateTypeProductTest
 * @package App\Tests\Unit
 */
class ShowTypeProductTest extends TestCase
{
    public function testSuccessfulTypeProductShowed()
    {
        $useCase = new ShowTypeProduct(new TypeProductRepository());

        $this->assertInstanceOf(TypeProduct::class, $useCase->execute(1));
    }

    /**
     * @dataProvider provideBadTypeProduct
     * @param int $typeproduct
     */
    public function testBadTypeProduct(int $typeproduct)
    {
        $useCase = new ShowTypeProduct(new TypeProductRepository());

        $this->assertNull($useCase->execute($typeproduct));
    }

    /**
     * @return \Generator
     */
    public function provideBadTypeProduct(): \Generator
    {
        yield [
            5
        ];
    }
}
