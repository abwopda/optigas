<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\CompanyFamilyRepository;
use App\Entity\CompanyFamily;
use App\UseCase\UseCompanyFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidateCompanyFamilyTest
 * @package App\Tests\Unit
 */
class ValidateCompanyFamilyTest extends TestCase
{
    public function testSuccessfulCompanyFamilyValidated()
    {
        $useCase = new UseCompanyFamily(new CompanyFamilyRepository());
        for ($i = 7; $i <= 7; $i++) {
            $entity = (new CompanyFamilyRepository())->findOneById($i);

            $this->assertInstanceOf(CompanyFamily::class, $useCase->validate($entity, true));

            $this->assertInstanceOf(CompanyFamily::class, $useCase->validate($entity, false));
        }
    }
}
