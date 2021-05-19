<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ActivateProductTest
 * @package App\Tests\Integration
 */
class ActivateProductTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulProductActivated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("product.activate", ["id" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("product.disable", ["id" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
