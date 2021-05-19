<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Entity\TypeProduct;
use App\UseCase\ActivateTypeProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivateTypeProductTest
 * @package App\Tests\Unit
 */
class ActivateTypeProductTest extends TestCase
{
    public function testSuccessfulTypeProductActivated()
    {
        $useCase = new ActivateTypeProduct(new TypeProductRepository());
        $typeproduct = $useCase->execute(1, 1);

        //var_export($typeproduct);

        $this->assertInstanceOf(TypeProduct::class, $typeproduct);

        $typeproduct = $useCase->execute(1, 0);

        //var_export($typeproduct);

        $this->assertInstanceOf(TypeProduct::class, $typeproduct);
    }
}
