<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\CompanyFamilyRepository;
use App\Entity\CompanyFamily;
use App\UseCase\UseCompanyFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivateCompanyFamilyTest
 * @package App\Tests\Unit
 */
class ActivateCompanyFamilyTest extends TestCase
{
    public function testSuccessfulCompanyFamilyActivated()
    {
        $useCase = new UseCompanyFamily(new CompanyFamilyRepository());
        for ($i = 7; $i <= 7; $i++) {
            $entity = (new CompanyFamilyRepository())->findOneById($i);

            $this->assertInstanceOf(CompanyFamily::class, $useCase->activate($entity, true));

            $this->assertInstanceOf(CompanyFamily::class, $useCase->activate($entity, false));
        }
    }
}
