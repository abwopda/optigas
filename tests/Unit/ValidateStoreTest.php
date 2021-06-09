<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\StoreRepository;
use App\Entity\Store;
use App\UseCase\UseStore;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidateStoreTest
 * @package App\Tests\Unit
 */
class ValidateStoreTest extends TestCase
{
    public function testSuccessfulStoreValidated()
    {
        $useCase = new UseStore(new StoreRepository());
        for ($i = 3; $i <= 3; $i++) {
            $entity = (new StoreRepository())->findOneById($i);

            $this->assertInstanceOf(Store::class, $useCase->validate($entity, true));

            $this->assertInstanceOf(Store::class, $useCase->validate($entity, false));
        }
    }
}
