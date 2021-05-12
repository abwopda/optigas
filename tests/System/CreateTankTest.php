<?php

namespace App\Tests\System;

use App\Adapter\InMemory\Repository\EmployeeRepository;
use App\Entity\Employee;
use App\UseCase\CreateTank;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class CreateTankTest
 * @package App\Tests\System
 */
class CreateTankTest extends \App\Tests\Integration\CreateTankTest
{
    use SystemTestTrait;
}
