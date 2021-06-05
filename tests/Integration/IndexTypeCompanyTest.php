<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class IndexTypeCompanyTest
 * @package App\Tests\Integration
 */
class IndexTypeCompanyTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulTypeCompanyIndexed()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("typecompany")
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
