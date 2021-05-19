<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ShowProductTest
 * @package App\Tests\Integration
 */
class ShowProductTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulProductShowed()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("product.show", ["id" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
