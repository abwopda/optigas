<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Entity\TypeProduct;
use App\UseCase\UseTypeProduct;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateTypeProductTest
 * @package App\Tests\Unit
 */
class UpdateTypeProductTest extends TestCase
{
    public function testSuccessfulTypeProductUpdated()
    {
        $useCase = new UseTypeProduct(new TypeProductRepository());

        for ($i = 3; $i <= 3; $i++) {
            $entity = (new TypeProductRepository())
                ->findOneById($i)
                ->setName("TYP0" . $i)
            ;
            $this->assertInstanceOf(TypeProduct::class, $useCase->update($entity));
        }
    }
}
