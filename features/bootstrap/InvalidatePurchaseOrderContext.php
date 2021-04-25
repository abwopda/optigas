<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class InvalidatePurchaseOrderContext implements Context
{
    /**
     * @Given /^i want to invalidate an existing validated purchaseorder$/
     */
    public function iWantToInvalidateAnExistingValidatedPurchaseorder()
    {
    }

    /**
     * @When /^i invalidate the purchaseorder$/
     */
    public function iInvalidateThePurchaseorder()
    {
    }

    /**
     * @Then /^the purchaseorder is invalidated and can be updated$/
     */
    public function thePurchaseorderIsInvalidatedAndCanBeUpdated()
    {
    }
}
