<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ShowPumpTest
 * @package App\Tests\Integration
 */
class ShowPumpTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulPumpShowed()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("pump.show", ["id" => 50])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 11; $i <= 11; $i++) {
            $crawler = $client->request(
                Request::METHOD_GET,
                $router->generate("pump.show", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        }
    }
}
