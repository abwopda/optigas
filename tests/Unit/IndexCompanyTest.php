<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\CompanyRepository;
use App\Entity\Company;
use App\UseCase\UseCompany;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexCompanyTest
 * @package App\Tests\Unit
 */
class IndexCompanyTest extends TestCase
{
    public function testSuccessfulCompanyIndexed()
    {
        $useCase = new UseCompany(new CompanyRepository());
        $this->assertContainsOnlyInstancesOf(Company::class, $useCase->findAll());
    }
}
