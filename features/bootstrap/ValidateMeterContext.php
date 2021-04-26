<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class ValidateMeterContext implements Context
{
    /**
     * @When /^i validate the meter$/
     */
    public function iValidateTheMeter()
    {
    }

    /**
     * @Given /^i want to validate an existing unvalidated meter$/
     */
    public function iWantToValidateAnExistingUnvalidatedMeter()
    {
    }

    /**
     * @Then /^the meter is validated and cannot be updated$/
     */
    public function theMeterIsValidatedAndCannotBeUpdated()
    {
    }
}
