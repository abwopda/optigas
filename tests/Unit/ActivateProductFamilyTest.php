<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Entity\ProductFamily;
use App\UseCase\ActivateProductFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivateProductFamilyTest
 * @package App\Tests\Unit
 */
class ActivateProductFamilyTest extends TestCase
{
    public function testSuccessfulProductFamilyActivated()
    {
        $useCase = new activateProductFamily(new ProductFamilyRepository());
        for ($i = 5; $i <= 5; $i++) {
            $entity = (new ProductFamilyRepository())->findOneById($i);

            $this->assertInstanceOf(ProductFamily::class, $useCase->execute($entity, true));

            $this->assertInstanceOf(ProductFamily::class, $useCase->execute($entity, false));
        }
    }
}
