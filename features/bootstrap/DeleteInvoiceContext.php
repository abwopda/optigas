<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class DeleteInvoiceContext implements Context
{
    /**
     * @When /^i select the invoice to delete$/
     */
    public function iSelectTheInvoiceToDelete()
    {
    }

    /**
     * @Given /^i want to delete an existing invoice$/
     */
    public function iWantToDeleteAnExistingInvoice()
    {
    }

    /**
     * @Then /^the invoice is no more available$/
     */
    public function theInvoiceIsNoMoreAvailable()
    {
    }
}
