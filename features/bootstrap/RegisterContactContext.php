<?php

namespace App\Features;

use App\Adapter\InMemory\Repository\ContactRepository;
use App\Entity\Contact;
use App\UseCase\RegisterContact;
use Assert\Assertion;
use Behat\Behat\Context\Context;

/**
 * Class RegisterContactContext
 * @package App\Features
 */
class RegisterContactContext implements Context
{
    /**
     * @var RegisterContact
     */
    private RegisterContact $registerContact;

    /**
     * @var Contact
     */
    private Contact $contact;
    /**
     * @Given /^a contact need to be registered before using the platform$/
     */
    public function aContactNeedToBeRegisteredBeforeUsingThePlatform()
    {
        $this->registerContact = new RegisterContact(new ContactRepository());
    }

    /**
     * @When /^an administrator fill the registration form$/
     */
    public function anAdministratorFillTheRegistrationForm()
    {
        $this->contact = new Contact();
        $this->contact->setPlainPassword("Password123!");
        $this->contact->setEmail("email@email.com");
        $this->contact->setFirstName("John");
        $this->contact->setLastName("Doe");
        $this->contact->setCompanyName("Company");
    }

    /**
     * @Then /^the contact can log in with the account created$/
     */
    public function theContactCanLogInWithTheAccountCreated()
    {
        Assertion::eq($this->contact,$this->registerContact->execute($this->contact));
    }
}