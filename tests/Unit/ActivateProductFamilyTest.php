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
        $tank = $useCase->execute(1, 1);

        //var_export($tank);

        $this->assertInstanceOf(ProductFamily::class, $tank);

        $tank = $useCase->execute(1, 0);

        //var_export($tank);

        $this->assertInstanceOf(ProductFamily::class, $tank);
    }
}
