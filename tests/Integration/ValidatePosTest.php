<?php

namespace App\Tests\Integration;

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
            Request::METHOD_POST,
            $router->generate("pos.validate.one", ["id" => 5])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("pos.invalidate.one", ["id" => 5])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 3; $i <= 3; $i++) {
            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("pos.validate.one", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);


            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("pos.invalidate.one", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        }
    }
}
