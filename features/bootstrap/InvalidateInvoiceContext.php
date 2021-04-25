<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class InvalidateInvoiceContext implements Context
{
    /**
     * @Given /^i want to invalidate an existing validated invoice$/
     */
    public function iWantToInvalidateAnExistingValidatedInvoice()
    {
    }

    /**
     * @When /^i invalidate the invoice$/
     */
    public function iInvalidateTheInvoice()
    {
    }

    /**
     * @Then /^the invoice is invalidated and can be updated$/
     */
    public function theInvoiceIsInvalidatedAndCanBeUpdated()
    {
    }
}
