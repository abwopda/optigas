<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class ValidateInvoiceContext implements Context
{
    /**
     * @When /^i validate the invoice$/
     */
    public function iValidateTheInvoice()
    {
    }

    /**
     * @Given /^i want to validate an existing unvalidated invoice$/
     */
    public function iWantToValidateAnExistingUnvalidatedInvoice()
    {
    }

    /**
     * @Then /^the invoice is validated and cannot be updated$/
     */
    public function theInvoiceIsValidatedAndCannotBeUpdated()
    {
    }
}
