<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\TypeCompanyRepository;
use App\Entity\TypeCompany;
use App\UseCase\UseTypeCompany;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexTypeCompanyTest
 * @package App\Tests\Unit
 */
class IndexTypeCompanyTest extends TestCase
{
    public function testSuccessfulTypeCompanyIndexed()
    {
        $useCase = new UseTypeCompany(new TypeCompanyRepository());
        $this->assertContainsOnlyInstancesOf(TypeCompany::class, $useCase->findAll());
    }
}
