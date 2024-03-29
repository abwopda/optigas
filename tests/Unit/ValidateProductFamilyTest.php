<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Entity\ProductFamily;
use App\UseCase\UseProductFamily;
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
        $useCase = new UseProductFamily(new ProductFamilyRepository());
        for ($i = 5; $i <= 5; $i++) {
            $entity = (new ProductFamilyRepository())->findOneById($i);

            $this->assertInstanceOf(ProductFamily::class, $useCase->validate($entity, true));

            $this->assertInstanceOf(ProductFamily::class, $useCase->validate($entity, false));
        }
    }
}
