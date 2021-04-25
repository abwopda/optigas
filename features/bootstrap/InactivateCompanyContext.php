<?php

namespace App\Features;

use Behat\Behat\Context\Context;

class InactivateCompanyContext implements Context
{
    /**
     * @When /^i inactivate the company$/
     */
    public function iInactivateTheCompany()
    {
    }

    /**
     * @Given /^i want to inactivate a existing company$/
     */
    public function iWantToInactivateAExistingCompany()
    {
    }

    /**
     * @Then /^the company cannot be used$/
     */
    public function theCompanyCannotBeUsed()
    {
    }
}
