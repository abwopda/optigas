<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ProductFamilyRepository;
use App\Entity\ProductFamily;
use App\UseCase\UseProductFamily;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteProductFamilyTest
 * @package App\Tests\Unit
 */
class DeleteProductFamilyTest extends TestCase
{
    public function testSuccessfulProductFamilyDeleted()
    {
        $useCase = new UseProductFamily(new ProductFamilyRepository());
        for ($i = 5; $i <= 5; $i++) {
            $entity = (new ProductFamilyRepository())->findOneById($i);

            $this->assertNull($useCase->delete($entity));
        }
    }
}
