<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Entity\TypeProduct;
use App\UseCase\ValidateTypeProduct;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidateTypeProductTest
 * @package App\Tests\Unit
 */
class ValidateTypeProductTest extends TestCase
{
    public function testSuccessfulTypeProductValidated()
    {
        $useCase = new ValidateTypeProduct(new TypeProductRepository());
        $typeproduct = $useCase->execute(1, 1);

        //var_export($typeproduct);

        $this->assertInstanceOf(TypeProduct::class, $typeproduct);

        $typeproduct = $useCase->execute(1, 0);

        //var_export($typeproduct);

        $this->assertInstanceOf(TypeProduct::class, $typeproduct);
    }
}
