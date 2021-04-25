<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class DeleteStockContext implements Context
{
    /**
     * @Given /^i want to delete an existing stock$/
     */
    public function iWantToDeleteAnExistingStock()
    {
    }

    /**
     * @When /^i select the stock to delete$/
     */
    public function iSelectTheStockToDelete()
    {
    }

    /**
     * @Then /^the stock is no more available$/
     */
    public function theStockIsNoMoreAvailable()
    {
    }
}
