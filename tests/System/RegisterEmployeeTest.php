<?php

namespace App\Tests\System;

use App\Adapter\InMemory\Repository\EmployeeRepository;
use App\Entity\Employee;
use App\UseCase\RegisterEmployee;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RegisterEmployeeTest
 * @package App\Tests\System
 */
class RegisterEmployeeTest extends \App\Tests\Integration\RegisterEmployeeTest
{
    use SystemTestTrait;
}
