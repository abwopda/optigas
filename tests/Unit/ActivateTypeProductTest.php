<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Entity\TypeProduct;
use App\UseCase\ActivateTypeProduct;
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
        for ($i = 1; $i <= 3; $i++) {
            $entity = (new TypeProductRepository())->findOneById($i);

            $this->assertInstanceOf(TypeProduct::class, $useCase->execute($entity, true));

            $this->assertInstanceOf(TypeProduct::class, $useCase->execute($entity, false));
        }
    }
}
