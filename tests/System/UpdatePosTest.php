<?php

namespace App\Tests\System;

use App\Adapter\InMemory\Repository\EmployeeRepository;
use App\Entity\Employee;
use App\UseCase\UpdatePos;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class UpdatePosTest
 * @package App\Tests\System
 */
class UpdatePosTest extends \App\Tests\Integration\UpdatePosTest
{
    use SystemTestTrait;
}
