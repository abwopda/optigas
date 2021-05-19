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
        $tank = $useCase->execute(1, 1);

        //var_export($tank);

        $this->assertInstanceOf(ProductFamily::class, $tank);

        $tank = $useCase->execute(1, 0);

        //var_export($tank);

        $this->assertInstanceOf(ProductFamily::class, $tank);
    }
}
