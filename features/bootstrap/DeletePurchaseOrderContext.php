<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class DeletePurchaseOrderContext implements Context
{
    /**
     * @When /^i select the purchaseorder to delete$/
     */
    public function iSelectThePurchaseorderToDelete()
    {
    }

    /**
     * @Given /^i want to delete an existing purchaseorder$/
     */
    public function iWantToDeleteAnExistingPurchaseorder()
    {
    }

    /**
     * @Then /^the purchaseorder is no more available$/
     */
    public function thePurchaseorderIsNoMoreAvailable()
    {
    }
}
