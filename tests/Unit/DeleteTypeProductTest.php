<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeProductRepository;
use App\Entity\TypeProduct;
use App\UseCase\UseTypeProduct;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteTypeProductTest
 * @package App\Tests\Unit
 */
class DeleteTypeProductTest extends TestCase
{
    public function testSuccessfulTypeProductDeleted()
    {
        $useCase = new UseTypeProduct(new TypeProductRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new TypeProductRepository())->findOneById($i);

            $this->assertNull($useCase->delete($entity));
        }
    }
}
