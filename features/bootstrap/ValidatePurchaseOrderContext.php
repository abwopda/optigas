<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class ValidatePurchaseOrderContext implements Context
{
    /**
     * @When /^i validate the purchaseorder$/
     */
    public function iValidateThePurchaseorder()
    {
    }

    /**
     * @Given /^i want to validate an existing unvalidated purchaseorder$/
     */
    public function iWantToValidateAnExistingUnvalidatedPurchaseorder()
    {
    }

    /**
     * @Then /^the purchaseorder is validated and cannot be updated$/
     */
    public function thePurchaseorderIsValidatedAndCannotBeUpdated()
    {
    }
}
