<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\CompanyFamilyRepository;
use App\Entity\CompanyFamily;
use App\UseCase\UseCompanyFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateCompanyFamilyTest
 * @package App\Tests\Unit
 */
class UpdateCompanyFamilyTest extends TestCase
{
    public function testSuccessfulCompanyFamilyUpdated()
    {
        $useCase = new UseCompanyFamily(new CompanyFamilyRepository());

        for ($i = 7; $i <= 7; $i++) {
            $entity = (new CompanyFamilyRepository())
                ->findOneById($i)
                ->setName("FAM0" . $i)
            ;
            $this->assertInstanceOf(CompanyFamily::class, $useCase->update($entity));
        }
    }
}
