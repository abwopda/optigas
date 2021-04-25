<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class ValidatePriceContext implements Context
{
    /**
     * @Then /^the price is validated and cannot be updated$/
     */
    public function thePriceIsValidatedAndCannotBeUpdated()
    {
    }

    /**
     * @Given /^i want to validate an existing unvalidated price$/
     */
    public function iWantToValidateAnExistingUnvalidatedPrice()
    {
    }

    /**
     * @When /^i validate the price$/
     */
    public function iValidateThePrice()
    {
    }
}
