<?php

namespace App\Tests\Integration;

use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class DeleteProductFamilyTest
 * @package App\Tests\Integration
 */
class DeleteProductFamilyTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulProductFamilyDeleted()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("productfamily.delete", ["id" => 10])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 5; $i <= 5; $i++) {
            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("productfamily.delete", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        }
    }
}
