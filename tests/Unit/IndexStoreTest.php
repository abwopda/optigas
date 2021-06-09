<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\StoreRepository;
use App\Entity\Store;
use App\UseCase\UseStore;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexStoreTest
 * @package App\Tests\Unit
 */
class IndexStoreTest extends TestCase
{
    public function testSuccessfulStoreIndexed()
    {
        $useCase = new UseStore(new StoreRepository());
        $this->assertContainsOnlyInstancesOf(Store::class, $useCase->findAll());
    }
}
