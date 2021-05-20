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
        for ($i = 1; $i <= 3; $i++) {
            $entity = (new TypeProductRepository())->findOneById($i);
            $this->assertInstanceOf(TypeProduct::class, $useCase->execute($entity));
        }
    }

    /**
     * @dataProvider provideBadTypeProduct
     * @param TypeProduct|null $typeproduct
     */
    public function testBadTypeProduct(?TypeProduct $typeproduct)
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
            (new TypeProductRepository())->findOneById(5)
        ];
    }
}
