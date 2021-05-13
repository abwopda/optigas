<?php

namespace App\Features;

use App\Adapter\InMemory\Repository\PosRepository;
use App\Entity\Pos;
use App\UseCase\CreatePos;
use Assert\Assertion;
use Behat\Behat\Context\Context;

class CreatePosContext implements Context
{
    private Pos $createPos;

    private Pos $pos;

    /**
     * @Given /^i want to create a new pos$/
     */
    public function iWantToCreateANewPos()
    {
        $this->createPos = new Pos(new PosRepository());
    }

    /**
     * @When i fill the form
     */
    public function iFillTheForm()
    {
        $this->pos = (new Pos())
            ->setCode("code")
            ->setName("name")
            ->setDescription("description")
            ->setTown("town")
            ->setAddress("adress")
            ->setCapacity(60000)
            ->setActive(true)
            ->setValid(true)
            ->setUpdateAt(new \DateTimeImmutable())
            ->setValidateAt(new \DateTimeImmutable())
            ->setActivateAt(new \DateTimeImmutable())
        ;
    }
    /**
     * @Then /^the pos can be used$/
     */
    public function thePosCanBeUsed()
    {
        Assertion::eq($this->pos, $this->createPos->execute($this->pos));
    }
}
