<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class DeletePurchaseDeliveryContext implements Context
{
    /**
     * @Given /^i want to delete an existing purchasedelivery$/
     */
    public function iWantToDeleteAnExistingPurchasedelivery()
    {
    }

    /**
     * @When /^i select the purchasedelivery to delete$/
     */
    public function iSelectThePurchasedeliveryToDelete()
    {
    }

    /**
     * @Then /^the purchasedelivery is no more available$/
     */
    public function thePurchasedeliveryIsNoMoreAvailable()
    {
    }
}
