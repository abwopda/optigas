<?php

namespace App\Tests\System;

use App\Adapter\InMemory\Repository\EmployeeRepository;
use App\Entity\Employee;
use App\UseCase\ActivatePos;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ActivatePosTest
 * @package App\Tests\System
 */
class ActivatePosTest extends \App\Tests\Integration\ActivatePosTest
{
    use SystemTestTrait;
}
