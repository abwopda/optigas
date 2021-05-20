<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ValidateProductFamilyTest
 * @package App\Tests\Integration
 */
class ValidateProductFamilyTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulProductFamilyValidated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");
        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("productfamily.validate", ["id" => 10])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("productfamily.invalidate", ["id" => 10])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 1; $i <= 5; $i++) {
            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("productfamily.validate", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);


            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("productfamily.invalidate", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        }
    }
}
