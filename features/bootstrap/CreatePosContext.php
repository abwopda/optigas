<?php

namespace App\Features;

use App\Entity\Pos;
use App\UseCase\CreatePos;
use Assert\Assertion;
use Behat\Behat\Context\Context;

class CreatePosContext implements Context
{
    private CreatePos $createPos;

    private Pos $pos;

    /**
     * @Given /^i want to create a new pos$/
     */
    public function iWantToCreateANewPos()
    {
        $this->createPos = new CreatePos();
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
            ->setUpdateAt(null)
            ->setValidateAt(null)
            ->setActivateAt(null)
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
