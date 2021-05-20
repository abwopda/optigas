<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Entity\ProductFamily;
use App\UseCase\IndexProductFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexProductFamilyTest
 * @package App\Tests\Unit
 */
class IndexProductFamilyTest extends TestCase
{
    public function testSuccessfulProductFamilyIndexed()
    {
        $useCase = new IndexProductFamily(new ProductFamilyRepository());
        $this->assertContainsOnlyInstancesOf(ProductFamily::class, $useCase->execute());
    }
}
