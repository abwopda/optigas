<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class UpdateStockContext implements Context
{
    /**
     * @Given /^i want to update an existing unvalidated stock$/
     */
    public function iWantToUpdateAnExistingUnvalidatedStock()
    {
    }

    /**
     * @Then /^the stock is updated and waiting for validation$/
     */
    public function theStockIsUpdatedAndWaitingForValidation()
    {
    }
}
