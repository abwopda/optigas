<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Retypeproductitory\TypeProductRetypeproductitory;
use App\Entity\TypeProduct;
use App\UseCase\UpdateTypeProduct;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ValidateTypeProductTest
 * @package App\Tests\Integration
 */
class ValidateTypeProductTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulTypeProductValidated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("typeproduct.validate", ["id" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $crawler = $client->request(
            Request::METHOD_GET,
            $router->generate("typeproduct.disable", ["id" => 1])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
