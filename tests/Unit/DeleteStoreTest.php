<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\StoreRepository;
use App\Entity\Store;
use App\UseCase\UseStore;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteStoreTest
 * @package App\Tests\Unit
 */
class DeleteStoreTest extends TestCase
{
    public function testSuccessfulStoreDeleted()
    {
        $useCase = new UseStore(new StoreRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new StoreRepository())->findOneById($i);

            $this->assertNull($useCase->delete($entity));
        }
    }
}
