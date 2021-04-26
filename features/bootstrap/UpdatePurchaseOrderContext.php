<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class UpdatePurchaseOrderContext implements Context
{
    /**
     * @Given /^i want to update an existing unvalidated purchaseorder$/
     */
    public function iWantToUpdateAnExistingUnvalidatedPurchaseorder()
    {
    }

    /**
     * @Then /^the purchaseorder is updated and waiting for validation$/
     */
    public function thePurchaseorderIsUpdatedAndWaitingForValidation()
    {
    }
}
