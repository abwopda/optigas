<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ShowProductFamilyTest
 * @package App\Tests\Integration
 */
class ShowProductFamilyTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulProductFamilyShowed()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("productfamily.show", ["id" => 10])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 5; $i <= 5; $i++) {
            $crawler = $client->request(
                Request::METHOD_GET,
                $router->generate("productfamily.show", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        }
    }
}
