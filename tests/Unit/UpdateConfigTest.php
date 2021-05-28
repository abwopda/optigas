<?php

namespace App\Tests\Unit;

use App\Adapter\InMemory\Repository\ConfigRepository;
use App\Entity\Config;
use App\UseCase\UpdateConfig;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateConfigTest
 * @package App\Tests\Unit
 */
class UpdateConfigTest extends TestCase
{
    public function testSuccessfulConfigUpdated()
    {
        $useCase = new updateConfig(new ConfigRepository());
        $config = (new ConfigRepository())
            ->findOneById(1)
            ->setTheKey("theKey" . "1")
            ->setTheValue("theValue" . "1")
        ;

        $this->assertInstanceOf(Config::class, $useCase->execute($config));
    }
}
