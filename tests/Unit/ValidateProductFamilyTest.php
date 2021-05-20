<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Entity\ProductFamily;
use App\UseCase\ValidateProductFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidateProductFamilyTest
 * @package App\Tests\Unit
 */
class ValidateProductFamilyTest extends TestCase
{
    public function testSuccessfulProductFamilyValidated()
    {
        $useCase = new validateProductFamily(new ProductFamilyRepository());
        for ($i = 1; $i <= 5; $i++) {
            $entity = (new ProductFamilyRepository())->findOneById($i);

            $this->assertInstanceOf(ProductFamily::class, $useCase->execute($entity, 1));

            $this->assertInstanceOf(ProductFamily::class, $useCase->execute($entity, 0));
        }
    }
}
