<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class DeletePriceContext implements Context
{
    /**
     * @When /^i select the price to delete$/
     */
    public function iSelectThePriceToDelete()
    {
    }

    /**
     * @Given /^i want to delete an existing price$/
     */
    public function iWantToDeleteAnExistingPrice()
    {
    }

    /**
     * @Then /^the price is no more available$/
     */
    public function thePriceIsNoMoreAvailable()
    {
    }
}
