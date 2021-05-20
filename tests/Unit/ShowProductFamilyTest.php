<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Entity\ProductFamily;
use App\UseCase\showProductFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ShowProductFamilyTest
 * @package App\Tests\Unit
 */
class ShowProductFamilyTest extends TestCase
{
    public function testSuccessfulProductFamilyShowed()
    {
        $useCase = new showProductFamily(new ProductFamilyRepository());
        for ($i = 1; $i <= 5; $i++) {
            $entity = (new ProductFamilyRepository())->findOneById($i);
            $this->assertInstanceOf(ProductFamily::class, $useCase->execute($entity));
        }
    }

    /**
     * @dataProvider provideBadProductFamily
     * @param ProductFamily|null $productfamily
     */
    public function testBadProductFamily(?ProductFamily $productfamily)
    {
        $useCase = new showProductFamily(new ProductFamilyRepository());

        $this->assertNull($useCase->execute($productfamily));
    }

    /**
     * @return \Generator
     */
    public function provideBadProductFamily(): \Generator
    {
        yield [
            (new ProductFamilyRepository())->findOneById(10)
        ];
    }
}
