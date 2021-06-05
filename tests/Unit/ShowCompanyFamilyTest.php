<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\CompanyFamilyRepository;
use App\Entity\CompanyFamily;
use App\UseCase\UseCompanyFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ShowCompanyFamilyTest
 * @package App\Tests\Unit
 */
class ShowCompanyFamilyTest extends TestCase
{
    public function testSuccessfulCompanyFamilyShowed()
    {
        $useCase = new UseCompanyFamily(new CompanyFamilyRepository());
        for ($i = 7; $i <= 7; $i++) {
            $entity = (new CompanyFamilyRepository())->findOneById($i);
            $this->assertInstanceOf(CompanyFamily::class, $useCase->show($entity));
        }
    }

    /**
     * @dataProvider provideBadCompanyFamily
     * @param CompanyFamily|null $companyfamily
     */
    public function testBadCompanyFamily(?CompanyFamily $companyfamily)
    {
        $useCase = new UseCompanyFamily(new CompanyFamilyRepository());

        $this->assertNull($useCase->show($companyfamily));
    }

    /**
     * @return \Generator
     */
    public function provideBadCompanyFamily(): \Generator
    {
        yield [
            (new CompanyFamilyRepository())->findOneById(10)
        ];
    }
}
