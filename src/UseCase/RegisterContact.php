<?php


namespace App\UseCase;

use App\Entity\Contact;
use App\Gateway\ContactGateway;
use Assert\Assert;

/**
 * Class RegisterContact
 * @package App\UseCase
 */
class RegisterContact
{
    /**
     * @var ContactGateway
     */
    private ContactGateway $contactGateway;

    /**
     * RegisterContact constructor.
     * @param ContactGateway $contactGateway
     */
    public function __construct(ContactGateway $contactGateway)
    {
        $this->contactGateway = $contactGateway;
    }

    /**
     * @param Contact $contact
     * @return Contact
     */
    public  function execute(Contact $contact) : Contact
    {
        //var_export($contact);
        Assert::lazy()
            ->that($contact->getFirstName(),"firstName")->notBlank()
            ->that($contact->getLastName(),"lastName")->notBlank()
            ->that($contact->getCompanyName(),"companyName")->notBlank()
            ->that($contact->getPlainPassword(),"plainPassword")
                ->notBlank()
                ->regex(
                    "/^(?:(?=.*[a-z])(?:(?=.*[A-Z])(?=.*[\d\W])|(?=.*\W)(?=.*\d))|(?=.*\W)(?=.*[A-Z])(?=.*\d)).{8,}$/"
                )
            ->that($contact->getEmail(),"email")
                ->notBlank()
                ->email()
            ->verifyNow()
        ;

        $this->contactGateway->register($contact);

        return $contact;
    }
}