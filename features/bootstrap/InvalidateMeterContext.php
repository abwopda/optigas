<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class InvalidateMeterContext implements Context
{
    /**
     * @When /^i invalidate the meter$/
     */
    public function iInvalidateTheMeter()
    {
    }

    /**
     * @Given /^i want to invalidate an existing validated meter$/
     */
    public function iWantToInvalidateAnExistingValidatedMeter()
    {
    }

    /**
     * @Then /^the meter is invalidated and can be updated$/
     */
    public function theMeterIsInvalidatedAndCanBeUpdated()
    {
    }
}
