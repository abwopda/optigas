<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ActivateTankTest
 * @package App\Tests\Integration
 */
class ActivateTankTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulTankActivated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("tank.activate.one", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("tank.disable.one", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 4; $i <= 4; $i++) {
            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("tank.activate.one", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);


            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("tank.disable.one", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        }
    }
}
