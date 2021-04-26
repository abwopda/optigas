<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class ValidateStockContext implements Context
{
    /**
     * @Given /^i want to validate an existing unvalidated stock$/
     */
    public function iWantToValidateAnExistingUnvalidatedStock()
    {
    }

    /**
     * @When /^i validate the stock$/
     */
    public function iValidateTheStock()
    {
    }

    /**
     * @Then /^the stock is validated and cannot be updated$/
     */
    public function theStockIsValidatedAndCannotBeUpdated()
    {
    }
}
