<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\CompanyFamilyRepository;
use App\Entity\CompanyFamily;
use App\UseCase\UseCompanyFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexCompanyFamilyTest
 * @package App\Tests\Unit
 */
class IndexCompanyFamilyTest extends TestCase
{
    public function testSuccessfulCompanyFamilyIndexed()
    {
        $useCase = new UseCompanyFamily(new CompanyFamilyRepository());
        $this->assertContainsOnlyInstancesOf(CompanyFamily::class, $useCase->findAll());
    }
}
