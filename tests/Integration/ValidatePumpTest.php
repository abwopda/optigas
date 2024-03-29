<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ValidatePumpTest
 * @package App\Tests\Integration
 */
class ValidatePumpTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulPumpValidated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("pump.validate.one", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("pump.invalidate.one", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 11; $i <= 11; $i++) {
            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("pump.validate.one", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);


            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("pump.invalidate.one", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        }
    }
}
