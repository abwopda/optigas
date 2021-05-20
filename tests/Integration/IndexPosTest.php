<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class IndexPosTest
 * @package App\Tests\Integration
 */
class IndexPosTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulPosIndexed()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("pos")
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
