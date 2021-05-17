<?php

namespace App\Tests\System;

use App\Adapter\InMemory\Repository\EmployeeRepository;
use App\Entity\Employee;
use App\UseCase\ShowPos;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ShowPosTest
 * @package App\Tests\System
 */
class ShowPosTest extends \App\Tests\Integration\ShowPosTest
{
    use SystemTestTrait;
}
