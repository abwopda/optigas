<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\CompanyFamilyRepository;
use App\Entity\CompanyFamily;
use App\UseCase\UseCompanyFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteCompanyFamilyTest
 * @package App\Tests\Unit
 */
class DeleteCompanyFamilyTest extends TestCase
{
    public function testSuccessfulCompanyFamilyDeleted()
    {
        $useCase = new UseCompanyFamily(new CompanyFamilyRepository());
        for ($i = 7; $i <= 7; $i++) {
            $entity = (new CompanyFamilyRepository())->findOneById($i);

            $this->assertNull($useCase->delete($entity));
        }
    }
}
