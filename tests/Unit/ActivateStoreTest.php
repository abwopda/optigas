<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\StoreRepository;
use App\Entity\Store;
use App\UseCase\UseStore;
use Assert\LazyAssertionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivateStoreTest
 * @package App\Tests\Unit
 */
class ActivateStoreTest extends TestCase
{
    public function testSuccessfulStoreActivated()
    {
        $useCase = new UseStore(new StoreRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new StoreRepository())->findOneById($i);

            $this->assertInstanceOf(Store::class, $useCase->activate($entity, true));

            $this->assertInstanceOf(Store::class, $useCase->activate($entity, false));
        }
    }
}
