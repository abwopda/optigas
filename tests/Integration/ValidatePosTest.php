<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\UpdatePos;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ValidatePosTest
 * @package App\Tests\Integration
 */
class ValidatePosTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulPosValidated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("pos.validate", ["id" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("pos.disable", ["id" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
