<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Entity\ProductFamily;
use App\UseCase\UpdateProductFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateProductFamilyTest
 * @package App\Tests\Unit
 */
class UpdateProductFamilyTest extends TestCase
{
    public function testSuccessfulProductFamilyUpdated()
    {
        $useCase = new updateProductFamily(new ProductFamilyRepository());

        for ($i = 1; $i <= 5; $i++) {
            $entity = (new ProductFamilyRepository())
                ->findOneById($i)
                ->setName("FAM0" . $i)
            ;
            $this->assertInstanceOf(ProductFamily::class, $useCase->execute($entity));
        }
    }
}
