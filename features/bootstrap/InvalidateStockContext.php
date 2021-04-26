<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class InvalidateStockContext implements Context
{
    /**
     * @Then /^the stock is invalidated and can be updated$/
     */
    public function theStockIsInvalidatedAndCanBeUpdated()
    {
    }

    /**
     * @Given /^i want to invalidate an existing validated stock$/
     */
    public function iWantToInvalidateAnExistingValidatedStock()
    {
    }

    /**
     * @When /^i invalidate the stock$/
     */
    public function iInvalidateTheStock()
    {
    }
}
