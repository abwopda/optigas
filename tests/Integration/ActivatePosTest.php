<?php

namespace App\Tests\Integration;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\UpdatePos;
use App\Tests\AuthenticationTrait;
use Assert\LazyAssertionException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ActivatePosTest
 * @package App\Tests\Integration
 */
class ActivatePosTest extends WebTestCase
{
    use AuthenticationTrait;

    public function testSuccessfulPosActivated()
    {
        $client = static::createAuthenticatedClient("employee@email.com");

        /**
         * @var RouterInterface $router
         */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("pos.activate", ["id" => 5])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $crawler = $client->request(
            Request::METHOD_POST,
            $router->generate("pos.disable", ["id" => 5])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        for ($i = 1; $i <= 3; $i++) {
            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("pos.activate", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);


            $crawler = $client->request(
                Request::METHOD_POST,
                $router->generate("pos.disable", ["id" => $i])
            );

            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        }
    }
}
