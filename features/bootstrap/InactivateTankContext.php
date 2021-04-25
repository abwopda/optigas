<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class InactivateTankContext implements Context
{
    /**
     * @Given /^i want to inactivate a existing tank$/
     */
    public function iWantToInactivateAExistingTank()
    {
    }

    /**
     * @When /^i inactivate the tank$/
     */
    public function iInactivateTheTank()
    {
    }

    /**
     * @Then /^the tank cannot be used$/
     */
    public function theTankCannotBeUsed()
    {
    }
}
