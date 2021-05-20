<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ShowPosTest
 * @package App\Tests\Integration
 */
class ShowPosTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulPosShowed()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("pos.show", ["id" => 5])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 1; $i <= 3; $i++) {
            $crawler = $client->request(
                Request::METHOD_GET,
                $router->generate("pos.show", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        }
    }
}
