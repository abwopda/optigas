<?php

namespace App\Tests\System;

use App\Adapter\InMemory\Repository\ContactRepository;
use App\Entity\Contact;
use App\UseCase\RegisterContact;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RegisterContactTest
 * @package App\Tests\System
 */
class RegisterContactTest extends \App\Tests\Integration\RegisterContactTest
{
    use SystemTestTrait;
}
