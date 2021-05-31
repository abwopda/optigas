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
            Request::METHOD_POST,
            $router->generate("product.activate.one", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("product.disable.one", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 3; $i <= 3; $i++) {
            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("product.activate.one", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);


            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("product.disable.one", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        }
    }
}
